<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    public function __construct() {
        parent::__construct();

        // 語系設定
        $this->language = $this->mod_config->getLanguage();
    }

    function authenticate($path_name, $func_name) {
        $auth = $this->check_api_file($path_name, $func_name);
        if ($auth['sys_code'] == 200) {
            $this->load->model('API/'.ucfirst($auth['path']), $auth['path']);
            $get_post_image_data = array();
            $get_post_image_data = array_merge($get_post_image_data, $this->get_post_data());
            $get_post_image_data = array_merge($get_post_image_data, $_FILES);
            $response = $this->$auth['path']->$auth['func']($get_post_image_data);
            echo json_encode($response);
        }
    }

    /**
     * 加入方法為可以在API自訂資料夾與名稱的Controller，
     * 主要是針對API去分開操作，至於路徑設定檔案，
     * 可以到Config資料夾內的routes_api.php進行新增。
     */
    function check_api_file($path_name, $func_name) {
        $routes = $this->config->item('routes_api');
        if (isset($routes[$path_name]) 
        && (isset($routes[$path_name]['post'][$func_name]) 
        || isset($routes[$path_name]['get'][$func_name]))) {
            // 辨識是用get or post
            if (isset($routes[$path_name]['get'][$func_name])) {
                $json_arr['method'] = 'get';
                $json_arr['func'] = $routes[$path_name]['get'][$func_name];
            } else if (isset($routes[$path_name]['post'][$func_name])) {
                $json_arr['method'] = 'post';
                $json_arr['func'] = $routes[$path_name]['post'][$func_name];
            }
            $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'success', 'GET_DATA_SUCCESS', $this->language);
            $json_arr['path'] = $path_name;
            return $json_arr;
        } else {
            $res = $this->check_api_table($path_name, $func_name);
            if ($res) {
                $json_arr = $this->to_work($path_name, $func_name, $this->get_post_data());
                echo json_encode($json_arr);
            } else {
                $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'error', 'DATA_FAIL', $this->language);
                echo json_encode($json_arr);
            }
        }
    }

    // 確認是否在routers_table名單上
    function check_api_table($path_name, $func_name) {
        $methods = $this->config->item('routes_table');
        if (isset($methods[$path_name])) {
            $work = false;
            foreach ($methods[$path_name]['method'] as $key => $value) {
                if ($value == $func_name) $work = $value;
            }
            return $work;
        } else {
            return false;
        }
    }

    // 取得傳輸進來的資料
    function get_post_data() {
        $getData = $this->input->get();
        $postData = $this->input->post();
        return array_merge($getData, $postData);
    }

    // 進行日常預設工作
    function to_work($path_name, $func_name, $data) {
        if ($func_name == 'exist') {
            return $this->to_work_exist($path_name, $func_name, $data);
        } else if ($func_name == 'insert') {
            return $this->to_work_insert($path_name, $func_name, $data);
        } else if ($func_name == 'update') {
            return $this->to_work_update($path_name, $func_name, $data);
        } else if ($func_name == 'delete') {
            return $this->to_work_delete($path_name, $func_name, $data);
        } else if ($func_name == 'get_list') {
            return $this->to_work_get_list($path_name, $func_name, $data);
        } else if ($func_name == 'get_once') {
            return $this->to_work_get_once($path_name, $func_name, $data);
        }
    }

    // 檢查名稱是否存在
    function to_work_exist($path_name, $func_name, $data) {
        $methods = $this->config->item('routes_table');
        $table = $methods[$path_name]['table'];
        $info = $methods[$path_name]['detals'][$func_name];

        // 驗證需要的元素
        $required = array();
        foreach ($info['require'] as $keyRequired => $valueRequired) {
            if (!isset($data[$valueRequired])) array_push($required, $valueRequired);
        }
        // 如果缺少資源跳出
        if (sizeof($required) > 0) {
            $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'error', 'MISSING_DATA', $this->language);
            $json_arr['requred'] = $required;
            return $json_arr;
        }

        // 負責驗證的元素
        $verify = array();
        foreach ($info['verify'] as $key => $value) {
            if (isset($data[$key])) $verify[$key] = $data[$key];
        }

        // 加入邏輯佇列
        $dataQuery['verify'] = $verify;
        $dataQuery['table'] = $table;
        $response = $this->mod_universal->chk_once($dataQuery);
        $json_arr['exist'] = $response;
        $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'success', 'GET_DATA_SUCCESS', $this->language);
        return $json_arr;
        
    }

    function to_work_insert($path_name, $func_name, $data) {
        $methods = $this->config->item('routes_table');
        $table = $methods[$path_name]['table'];
        $info = $methods[$path_name]['detals'][$func_name];

        // 驗證需要的元素
        $required = array();
        foreach ($info['require'] as $keyRequired => $valueRequired) {
            if (!isset($data[$valueRequired])) array_push($required, $valueRequired);
        }
        // 如果缺少資源跳出
        if (sizeof($required) > 0) {
            $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'error', 'MISSING_DATA', $this->language);
            $json_arr['requred'] = $required;
            return $json_arr;
        }

        // 負責寫入元素內容
        $query = array();
        foreach ($info['query'] as $key => $value) {
            if (isset($data[$key])) $query[$key] = $data[$key];
        }

        // 加入預設條件
        $query = array_merge($query, $this->set_default_data($info['default']));

        // 加入邏輯佇列
        $dataQuery['data'] = $query;
        $dataQuery['table'] = $table;
        $response = $this->mod_universal->insert($dataQuery);
        $json_arr['response'] = $response;
        $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'success', 'GET_DATA_SUCCESS', $this->language);
        return $json_arr;
        
    }

    function to_work_update($path_name, $func_name, $data) {
        $methods = $this->config->item('routes_table');
        $table = $methods[$path_name]['table'];
        $info = $methods[$path_name]['detals'][$func_name];

        // 驗證需要的元素
        $required = array();
        foreach ($info['require'] as $keyRequired => $valueRequired) {
            if (!isset($data[$valueRequired])) array_push($required, $valueRequired);
        }
        // 如果缺少資源跳出
        if (sizeof($required) > 0) {
            $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'error', 'DATA_FAIL', $this->language);
            $json_arr['requred'] = $required;
            return $json_arr;
        }

        // 負責驗證的元素
        $verify = array();
        foreach ($info['verify'] as $key => $value) {
            if (isset($data[$key])) $verify[$key] = $data[$key];
        }

        // 負責寫入元素內容
        $query = array();
        foreach ($info['query'] as $key => $value) {
            if (isset($data[$key])) $query[$key] = $data[$key];
        }

        // 加入預設條件
        $query = array_merge($query, $this->set_default_data($info['default']));

        // 加入邏輯佇列
        $dataQuery['verify'] = $verify;
        $dataQuery['data'] = $query;
        $dataQuery['table'] = $table;
        $response = $this->mod_universal->update($dataQuery);
        $json_arr['response'] = $response;
        $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'success', 'GET_DATA_SUCCESS', $this->language);
        return $json_arr;
        
    }

    function to_work_delete($path_name, $func_name, $data) {
        $methods = $this->config->item('routes_table');
        $table = $methods[$path_name]['table'];
        $info = $methods[$path_name]['detals'][$func_name];

        // 驗證需要的元素
        $required = array();
        foreach ($info['require'] as $keyRequired => $valueRequired) {
            if (!isset($data[$valueRequired])) array_push($required, $valueRequired);
        }
        // 如果缺少資源跳出
        if (sizeof($required) > 0) {
            $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'error', 'DATA_FAIL', $this->language);
            $json_arr['requred'] = $required;
            return $json_arr;
        }

        // 負責驗證的元素
        $verify = array();
        foreach ($info['verify'] as $key => $value) {
            if (isset($data[$key])) $verify[$key] = $data[$key];
        }

        // 加入邏輯佇列
        $dataQuery['verify'] = $verify;
        $dataQuery['table'] = $table;
        $response = $this->mod_universal->delete($dataQuery);
        $json_arr['response'] = $response;
        $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'success', 'GET_DATA_SUCCESS', $this->language);
        return $json_arr;
        
    }

    function to_work_get_list($path_name, $func_name, $data) {
        $methods = $this->config->item('routes_table');
        $table = $methods[$path_name]['table'];
        $info = $methods[$path_name]['detals'][$func_name];

        // 驗證需要的元素
        $required = array();
        foreach ($info['require'] as $keyRequired => $valueRequired) {
            if (!isset($data[$valueRequired])) array_push($required, $valueRequired);
        }
        // 如果缺少資源跳出
        if (sizeof($required) > 0) {
            $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'error', 'DATA_FAIL', $this->language);
            $json_arr['requred'] = $required;
            return $json_arr;
        }

        // 負責驗證的元素
        $verify = array();
        foreach ($info['verify'] as $key => $value) {
            if (isset($data[$key])) $verify[$key] = $data[$key];
        }

        // 負責寫入關鍵字元素內容
        $likes = array();
        foreach ($info['likes'] as $key => $value) {
            if (isset($data[$key])) $likes[$key] = $data[$key];
        }

        // 負責寫入限制元素
        $record = array();
        foreach ($info['record'] as $key => $value) {
            if (isset($data[$key])) $record[$key] = $data[$key];
        }

        // 確認資料數量 預設抓取 30 筆資料
        if (!isset($record['limit'])) {
            $record['limit'] = 30;
        }

        // 確認頁數
        if (!isset($record['page'])) {
            $record['page'] = 1;
        }

        // 加入邏輯佇列
        $dataQuery['verify'] = $verify;
        $dataQuery['likes'] = $likes;
        $dataQuery['record'] = $record;
        $dataQuery['table'] = $table;
        $response = $this->mod_universal->get_list($dataQuery);
        $json_arr['response'] = $response;
        $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'success', 'GET_DATA_SUCCESS', $this->language);
        return $json_arr;
        
    }

    function to_work_get_once($path_name, $func_name, $data) {
        $methods = $this->config->item('routes_table');
        $table = $methods[$path_name]['table'];
        $info = $methods[$path_name]['detals'][$func_name];

        // 驗證需要的元素
        $required = array();
        foreach ($info['require'] as $keyRequired => $valueRequired) {
            if (!isset($data[$valueRequired])) array_push($required, $valueRequired);
        }
        // 如果缺少資源跳出
        if (sizeof($required) > 0) {
            $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'error', 'DATA_FAIL', $this->language);
            $json_arr['requred'] = $required;
            return $json_arr;
        }

        // 負責驗證的元素
        $verify = array();
        foreach ($info['verify'] as $key => $value) {
            if (isset($data[$key])) $verify[$key] = $data[$key];
        }

        // 負責寫入關鍵字元素內容
        $likes = array();
        foreach ($info['likes'] as $key => $value) {
            if (isset($data[$key])) $likes[$key] = $data[$key];
        }

        // 加入邏輯佇列
        $dataQuery['verify'] = $verify;
        $dataQuery['likes'] = $likes;
        $dataQuery['table'] = $table;
        $response = $this->mod_universal->get_once($dataQuery);
        $json_arr['response'] = $response;
        $json_arr = $this->mod_config->msgResponse((isset($json_arr))?$json_arr:array(), 'success', 'GET_DATA_SUCCESS', $this->language);
        return $json_arr;
    }

    // 寫入預設條件
    function set_default_data($data) {
        $res = array();
        foreach ($data as $key => $value) {
            # code...
            if ($value == 'code_date') {
                $res[$key] = date('Y-m-d');
            } else if ($value == 'code_time') {
                $res[$key] = date('H:i:s');
            } else if ($value == 'code_timestamp') {
                $res[$key] = time();
            } else if ($value == 'code_uniqid') {
                $res[$key] = uniqid(time());
            } else {
                $res[$key] = $value;
            }
        }
        return $res;
    }

}

?>
