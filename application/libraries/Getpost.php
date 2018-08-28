<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* v.01  過濾必填與非必填功能
* 
*
**/

class Getpost {
    /**
     * 專門給API使用，不需要透過CI URL
     * 主要是針對透過授權進入API頁面
     * 事先會把資料抓取出來，所以只需要去做比較即可。
     */
	function getpost_array_for_api($getpostData = array(), $need = array(), $requred = array()){
		$res = array();
		foreach ($need as $key => $value) {
            // 檢查是否在需要名單內
			if (in_array($value, $requred) && !isset($getpostData[$value])){
				return false;
			} else {
                // 檢查是否有檔案的參數
                if (substr($value, 0, 5) == 'FILE_') {
                    $res['tmp_'.substr($value, strlen($value) - 5)] = $getpostData[$value];
                } else {
                    // 一般的參數
                    if (isset($getpostData[$value])) {
                        $res[$value] = $getpostData[$value];
                    } else {
                        $res[$value] = '';
                    }
                }
			}
		}
		return $res;
    }
    
    // 將需要的GET POST 資料轉成一個陣列處理 res 陣列回傳	
    // data 取得所有要拿的資料
    // requred 需要必填的資料
	function getpost_array($data,$requred = array()){
		$CI =& get_instance();
		$CI->load->helper('url');
		$res = array();
		foreach ($data as $key => $value) {
			# code...
			if(in_array($value, $requred)){
				if($CI->input->get_post($value) == ""){
					return false;
				}else{
					$res[$value] = $CI->input->get_post($value);
				}
			}else{
				$res[$value] = $CI->input->get_post($value);
			}
			
		}
		return $res;
	}

    // 檢查必填資料，沒有被填寫到的資料就會被丟回陣列回傳
	function report_requred($data){
		$CI =& get_instance();
		$CI->load->helper('url');
		$res = array();
		foreach ($data as $key => $value) {
			if($CI->input->get_post($value) == ""){
				$res[] = $value;
			}
		}
		return $res;
    }
    
    // 檢查限定內容欄位
	function chk_assign_val($value,$assign_val){
		foreach ($assign_val as $k => $v) {
			# code...
			if($v == $value){
				return true;
			}
		}
		return false;
	}
}

/* End of file Getpost.php */
/* Location: ./application/libraries/Getpost.php */
