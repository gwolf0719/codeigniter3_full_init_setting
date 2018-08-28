<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mod_config extends CI_Model {
    public function __construct() {
        parent::__construct();

        $this->errCode = $this->config->item('err_code');
        $this->sucCode = $this->config->item('suc_code');
    }

    // 取得回傳訊息資料
    function msgResponse($response, $type, $code, $lang = 'default') {
        if ($type == 'error') {
            return array_merge($response, $this->packageResponse($this->errCode[$code], $lang));
        } else if ($type == 'success') {
            return array_merge($response, $this->packageResponse($this->sucCode[$code], $lang));
        }
    }

    // 打包回傳訊息
    function packageResponse($codeData, $lang) {
        $resData['sys_code'] = $codeData['sys_code'];
        $resData['sys_num'] = $codeData['sys_num'];
        if (isset($codeData['sys_msg'][$lang])) {
            $resData['sys_msg'] = $codeData['sys_msg'][$lang];
        } else {
            $resData['sys_msg'] = $codeData['sys_msg']['zh-tw'];
        }
        return $resData;
    }

    // 取得當前語系
    function getLanguage() {
        // 語系設定
        $this->load->helper('cookie');
        $lang = $this->input->get('lang');
        if ($lang) {
            // 設定
            if (in_array($lang, $this->config->item('lang'))) {
                $this->language = $lang;
                $this->input->set_cookie('language', $lang, 86400);
            } else {
                $this->language = 'zh-tw';
                $this->input->set_cookie('language', 'zh-tw', 86400);
            }
        } else {
            // 正常
            if ($this->input->cookie('language')) {
                $this->language = $this->input->cookie('language');
            } else {
                $this->language = 'zh-tw';
            }
        }
        return $this->language;
    }
}

/* End of file Mod_config.php */

?>