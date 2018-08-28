<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mod_mongo extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 確認資料是否存在
     * $where = 寫入的條件式
     * $like = 傳入相似關鍵字
     * $table = 資料庫名稱
     */
    function chk_once($dataQuery){
        if (isset($dataQuery['verify'])) $this->mongo_db->where($dataQuery['verify']);
        if (isset($dataQuery['likes'])) {
            foreach ($dataQuery['likes'] as $key => $value) {
                # code...
                $this->mongo_db->like($key, $value);
            }
        }
        if (isset($dataQuery['record']['between'])) {
            $this->mongo_db->where_between($dataQuery['record']['between']['item'], 
            $dataQuery['record']['between']['start'], $dataQuery['record']['between']['end']);
        }
        if (isset($dataQuery['record']['wherein'])) {
            $this->mongo_db->where_in($dataQuery['record']['wherein']['key'], $dataQuery['record']['wherein']['value']);
        }
        if (isset($dataQuery['record']['orwhere'])) {
            $this->mongo_db->where_in($dataQuery['record']['orwhere']['key'], $dataQuery['record']['orwhere']['value']);
        }
        if (isset($dataQuery['record']['wheregte'])) {
            $this->mongo_db->where_gte($dataQuery['record']['wheregte']['key'], $dataQuery['record']['wheregte']['value']);
        }
        if (isset($dataQuery['record']['wherelte'])) {
            $this->mongo_db->where_lte($dataQuery['record']['wherelte']['key'], $dataQuery['record']['wherelte']['value']);
        }
        if (isset($dataQuery['record']['where_not_in'])) {
            $this->mongo_db->where_not_in($dataQuery['record']['where_not_in']['key'], $dataQuery['record']['where_not_in']['value']);
        }
        if (isset($dataQuery['record']['order_by'])) {
            $this->mongo_db->order_by($dataQuery['record']['order_by']);
        } else {
            $this->mongo_db->order_by(array('createAt'=> 'DESC', 'createAtTime'=> 'DESC'));
        }

        $response = $this->mongo_db->count($dataQuery['table']);
        if ($response == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 取得資料數量
     * $where = 寫入的條件式
     * $like = 傳入相似關鍵字
     * $table = 資料庫名稱
     */
    function get_count($dataQuery){
        if (isset($dataQuery['verify'])) $this->mongo_db->where($dataQuery['verify']);
        if (isset($dataQuery['likes'])) {
            foreach ($dataQuery['likes'] as $key => $value) {
                # code...
                $this->mongo_db->like($key, $value);
            }
        }
        if (isset($dataQuery['record']['between'])) {
            $this->mongo_db->where_between($dataQuery['record']['between']['item'], 
            $dataQuery['record']['between']['start'], $dataQuery['record']['between']['end']);
        }
        if (isset($dataQuery['record']['wherein'])) {
            $this->mongo_db->where_in($dataQuery['record']['wherein']['key'], $dataQuery['record']['wherein']['value']);
        }
        if (isset($dataQuery['record']['orwhere'])) {
            $this->mongo_db->where_in($dataQuery['record']['orwhere']['key'], $dataQuery['record']['orwhere']['value']);
        }
        if (isset($dataQuery['record']['wheregte'])) {
            $this->mongo_db->where_gte($dataQuery['record']['wheregte']['key'], $dataQuery['record']['wheregte']['value']);
        }
        if (isset($dataQuery['record']['wherelte'])) {
            $this->mongo_db->where_lte($dataQuery['record']['wherelte']['key'], $dataQuery['record']['wherelte']['value']);
        }
        if (isset($dataQuery['record']['where_not_in'])) {
            $this->mongo_db->where_not_in($dataQuery['record']['where_not_in']['key'], $dataQuery['record']['where_not_in']['value']);
        }
        if (isset($dataQuery['record']['order_by'])) {
            $this->mongo_db->order_by($dataQuery['record']['order_by']);
        } else {
            $this->mongo_db->order_by(array('createAt'=> 'DESC', 'createAtTime'=> 'DESC'));
        }

        $response = $this->mongo_db->count($dataQuery['table']);
        return $response;
    }

    /**
     * 取得單一資料
     * $where = 寫入的條件式
     * $like = 傳入相似關鍵字
     * $table = 資料庫名稱
     */
    function get_once($dataQuery){
        if (isset($dataQuery['verify'])) $this->mongo_db->where($dataQuery['verify']);
        if (isset($dataQuery['likes'])) {
            foreach ($dataQuery['likes'] as $key => $value) {
                # code...
                $this->mongo_db->like($key, $value);
            }
        }
        if (isset($dataQuery['record']['between'])) {
            $this->mongo_db->where_between($dataQuery['record']['between']['item'], 
            $dataQuery['record']['between']['start'], $dataQuery['record']['between']['end']);
        }
        if (isset($dataQuery['record']['wherein'])) {
            $this->mongo_db->where_in($dataQuery['record']['wherein']['key'], $dataQuery['record']['wherein']['value']);
        }
        if (isset($dataQuery['record']['orwhere'])) {
            $this->mongo_db->where_in($dataQuery['record']['orwhere']['key'], $dataQuery['record']['orwhere']['value']);
        }
        if (isset($dataQuery['record']['wheregte'])) {
            $this->mongo_db->where_gte($dataQuery['record']['wheregte']['key'], $dataQuery['record']['wheregte']['value']);
        }
        if (isset($dataQuery['record']['wherelte'])) {
            $this->mongo_db->where_lte($dataQuery['record']['wherelte']['key'], $dataQuery['record']['wherelte']['value']);
        }
        if (isset($dataQuery['record']['where_not_in'])) {
            $this->mongo_db->where_not_in($dataQuery['record']['where_not_in']['key'], $dataQuery['record']['where_not_in']['value']);
        }
        if (isset($dataQuery['record']['order_by'])) {
            $this->mongo_db->order_by($dataQuery['record']['order_by']);
        } else {
            $this->mongo_db->order_by(array('createAt'=> 'DESC', 'createAtTime'=> 'DESC'));
        }

        $response = $this->mongo_db->find_one($dataQuery['table']);
        return $response;
    }

    /**
     * 取得特定資料
     * $where = 寫入的條件式
     * $like = 傳入相似關鍵字
     * $table = 資料庫名稱
     */
    function get_list($dataQuery){
        if (isset($dataQuery['verify'])) $this->mongo_db->where($dataQuery['verify']);
        if (isset($dataQuery['likes'])) {
            foreach ($dataQuery['likes'] as $key => $value) {
                $this->mongo_db->like($key, $value);
            }
        }
        if (isset($dataQuery['record']['limit'])) $this->mongo_db->limit($dataQuery['record']['limit']);
        if (isset($dataQuery['record']['page'])) $this->mongo_db->offset($dataQuery['record']['limit']*($dataQuery['record']['page'] - 1));
        if (isset($dataQuery['record']['between'])) {
            $this->mongo_db->where_between($dataQuery['record']['between']['item'], 
            $dataQuery['record']['between']['start'], $dataQuery['record']['between']['end']);
        }
        if (isset($dataQuery['record']['wherein'])) {
            $this->mongo_db->where_in($dataQuery['record']['wherein']['key'], $dataQuery['record']['wherein']['value']);
        }
        if (isset($dataQuery['record']['orwhere'])) {
            $this->mongo_db->where_in($dataQuery['record']['orwhere']['key'], $dataQuery['record']['orwhere']['value']);
        }
        if (isset($dataQuery['record']['wheregte'])) {
            $this->mongo_db->where_gte($dataQuery['record']['wheregte']['key'], $dataQuery['record']['wheregte']['value']);
        }
        if (isset($dataQuery['record']['wherelte'])) {
            $this->mongo_db->where_lte($dataQuery['record']['wherelte']['key'], $dataQuery['record']['wherelte']['value']);
        }
        if (isset($dataQuery['record']['where_not_in'])) {
            $this->mongo_db->where_not_in($dataQuery['record']['where_not_in']['key'], $dataQuery['record']['where_not_in']['value']);
        }
        if (isset($dataQuery['record']['order_by'])) {
            $this->mongo_db->order_by($dataQuery['record']['order_by']);
        } else {
            $this->mongo_db->order_by(array('createAt'=> 'DESC', 'createAtTime'=> 'DESC'));
        }

        $response = $this->mongo_db->get($dataQuery['table']);
        return $response;
    }

    /**
     * 取得特定資料
     * $where = 寫入的條件式
     * $like = 傳入相似關鍵字
     * $table = 資料庫名稱
     */
    function get_all($dataQuery){
        if (isset($dataQuery['verify'])) $this->mongo_db->where($dataQuery['verify']);
        if (isset($dataQuery['likes'])) {
            foreach ($dataQuery['likes'] as $key => $value) {
                # code...
                $this->mongo_db->like($key, $value);
            }
        }
        if (isset($dataQuery['record']['between'])) {
            $this->mongo_db->where_between($dataQuery['record']['between']['item'], 
            $dataQuery['record']['between']['start'], $dataQuery['record']['between']['end']);
        }
        if (isset($dataQuery['record']['wheregte'])) {
            $this->mongo_db->where_gte($dataQuery['record']['wheregte']['key'], $dataQuery['record']['wheregte']['value']);
        }
        if (isset($dataQuery['record']['wherelte'])) {
            $this->mongo_db->where_lte($dataQuery['record']['wherelte']['key'], $dataQuery['record']['wherelte']['value']);
        }
        if (isset($dataQuery['record']['wherein'])) {
            $this->mongo_db->where_in($dataQuery['record']['wherein']['key'], $dataQuery['record']['wherein']['value']);
        }
        if (isset($dataQuery['record']['where_not_in'])) {
            $this->mongo_db->where_not_in($dataQuery['record']['where_not_in']['key'], $dataQuery['record']['where_not_in']['value']);
        }
        if (isset($dataQuery['record']['order_by'])) {
            $this->mongo_db->order_by($dataQuery['record']['order_by']);
        } else {
            $this->mongo_db->order_by(array('createAt'=> 'DESC', 'createAtTime'=> 'DESC'));
        }

        $response = $this->mongo_db->get($dataQuery['table']);
        return $response;
    }

    /**
     * 新增資料
     * $data = 傳入的資料內容
     * $table = 資料庫名稱
     */
    function insert($dataQuery) {
        $dataQuery['data']['createAt'] = date('Y-m-d');
        $dataQuery['data']['createAtTime'] = date('H:i:s');
        $dataQuery['data']['tsCreateAt'] = time();
        $response = $this->mongo_db->insert($dataQuery['table'], $dataQuery['data']);
        return $response;
    }

    /**
     * 更新資料
     * $where = 寫入的條件式
     * $data = 傳入的資料內容
     * $table = 資料庫名稱
     */
    function update($dataQuery) {
        $dataQuery['data']['updateAt'] = date('Y-m-d');
        $dataQuery['data']['updateAtTime'] = date('H:i:s');
        $dataQuery['data']['tsUpdateAt'] = time();
        if (isset($dataQuery['verify'])) $this->mongo_db->where($dataQuery['verify']);
        if (isset($dataQuery['likes'])) {
            foreach ($dataQuery['likes'] as $key => $value) {
                # code...
                $this->mongo_db->like($key, $value);
            }
        }
        if (isset($dataQuery['record']['between'])) {
            $this->mongo_db->where_between($dataQuery['record']['between']['item'], 
            $dataQuery['record']['between']['start'], $dataQuery['record']['between']['end']);
        }
        if (isset($dataQuery['record']['wherein'])) {
            $this->mongo_db->where_in($dataQuery['record']['wherein']['key'], $dataQuery['record']['wherein']['value']);
        }
        if (isset($dataQuery['record']['orwhere'])) {
            $this->mongo_db->where_in($dataQuery['record']['orwhere']['key'], $dataQuery['record']['orwhere']['value']);
        }
        if (isset($dataQuery['record']['wheregte'])) {
            $this->mongo_db->where_gte($dataQuery['record']['wheregte']['key'], $dataQuery['record']['wheregte']['value']);
        }
        if (isset($dataQuery['record']['wherelte'])) {
            $this->mongo_db->where_lte($dataQuery['record']['wherelte']['key'], $dataQuery['record']['wherelte']['value']);
        }
        if (isset($dataQuery['record']['where_not_in'])) {
            $this->mongo_db->where_not_in($dataQuery['record']['where_not_in']['key'], $dataQuery['record']['where_not_in']['value']);
        }
        if (isset($dataQuery['record']['order_by'])) {
            $this->mongo_db->order_by($dataQuery['record']['order_by']);
        } else {
            $this->mongo_db->order_by(array('createAt'=> 'DESC', 'createAtTime'=> 'DESC'));
        }

        $this->mongo_db->set($dataQuery['data']);
        $response = $this->mongo_db->update_all($dataQuery['table']);
        return $response;
    }

    /**
     * 刪除資料
     * $where = 寫入的條件式
     * $table = 資料庫名稱
     */
    function delete($dataQuery) {
        if (isset($dataQuery['verify'])) $this->mongo_db->where($dataQuery['verify']);
        if (isset($dataQuery['likes'])) {
            foreach ($dataQuery['likes'] as $key => $value) {
                # code...
                $this->mongo_db->like($key, $value);
            }
        }
        if (isset($dataQuery['record']['between'])) {
            $this->mongo_db->where_between($dataQuery['record']['between']['item'], 
            $dataQuery['record']['between']['start'], $dataQuery['record']['between']['end']);
        }
        if (isset($dataQuery['record']['wherein'])) {
            $this->mongo_db->where_in($dataQuery['record']['wherein']['key'], $dataQuery['record']['wherein']['value']);
        }
        if (isset($dataQuery['record']['orwhere'])) {
            $this->mongo_db->where_in($dataQuery['record']['orwhere']['key'], $dataQuery['record']['orwhere']['value']);
        }
        if (isset($dataQuery['record']['wheregte'])) {
            $this->mongo_db->where_gte($dataQuery['record']['wheregte']['key'], $dataQuery['record']['wheregte']['value']);
        }
        if (isset($dataQuery['record']['wherelte'])) {
            $this->mongo_db->where_lte($dataQuery['record']['wherelte']['key'], $dataQuery['record']['wherelte']['value']);
        }
        if (isset($dataQuery['record']['where_not_in'])) {
            $this->mongo_db->where_not_in($dataQuery['record']['where_not_in']['key'], $dataQuery['record']['where_not_in']['value']);
        }
        if (isset($dataQuery['record']['order_by'])) {
            $this->mongo_db->order_by($dataQuery['record']['order_by']);
        } else {
            $this->mongo_db->order_by(array('createAt'=> 'DESC', 'createAtTime'=> 'DESC'));
        }

        $response = $this->mongo_db->delete($dataQuery['table']);
        return $response;
    }

    /**
     * 刪除資料
     * $where = 寫入的條件式
     * $table = 資料庫名稱
     */
    function delete_all($dataQuery) {
        if (isset($dataQuery['verify'])) $this->mongo_db->where($dataQuery['verify']);
        if (isset($dataQuery['likes'])) {
            foreach ($dataQuery['likes'] as $key => $value) {
                # code...
                $this->mongo_db->like($key, $value);
            }
        }
        if (isset($dataQuery['record']['between'])) {
            $this->mongo_db->where_between($dataQuery['record']['between']['item'], 
            $dataQuery['record']['between']['start'], $dataQuery['record']['between']['end']);
        }
        if (isset($dataQuery['record']['wherein'])) {
            $this->mongo_db->where_in($dataQuery['record']['wherein']['key'], $dataQuery['record']['wherein']['value']);
        }
        if (isset($dataQuery['record']['orwhere'])) {
            $this->mongo_db->where_in($dataQuery['record']['orwhere']['key'], $dataQuery['record']['orwhere']['value']);
        }
        if (isset($dataQuery['record']['wheregte'])) {
            $this->mongo_db->where_gte($dataQuery['record']['wheregte']['key'], $dataQuery['record']['wheregte']['value']);
        }
        if (isset($dataQuery['record']['wherelte'])) {
            $this->mongo_db->where_lte($dataQuery['record']['wherelte']['key'], $dataQuery['record']['wherelte']['value']);
        }
        if (isset($dataQuery['record']['where_not_in'])) {
            $this->mongo_db->where_not_in($dataQuery['record']['where_not_in']['key'], $dataQuery['record']['where_not_in']['value']);
        }
        if (isset($dataQuery['record']['order_by'])) {
            $this->mongo_db->order_by($dataQuery['record']['order_by']);
        } else {
            $this->mongo_db->order_by(array('createAt'=> 'DESC', 'createAtTime'=> 'DESC'));
        }
        
        $response = $this->mongo_db->delete_all($dataQuery['table']);
        return $response;
    }
}

/* End of file Mod_general.php */

?>