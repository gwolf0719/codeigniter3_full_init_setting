<?php 

  // 主要放置所有的成功碼與預設回應，未來可以自動加載到各個編輯器。

  /**
   * @apiDefine sucCodeExample
   * @apiSuccessExample {json} Response-Example:
   * {
   *      "sys_code": "回應編號",
   *      "sys_num": "成功編號",
   *      "sys_msg": "成功訊息"
   * }
   */

  /**
   * @apiDefine sucCode_20001
   * @apiSuccess SIGNIN_SUCCESS 20001 登入成功
   */
  $config['suc_code']['SIGNIN_SUCCESS'] = array(
      "sys_code"=> "200",
      "sys_num"=> "20001",
      "sys_msg"=> array(
          "zh-tw"=> '登入成功',
          "zh-cn"=> '登入成功',
          "en-us"=> 'Signin Success'
      )
  );

  /**
   * @apiDefine sucCode_20002
   * @apiSuccess GET_DATA_SUCCESS 20002 資料存取成功
   */
  $config['suc_code']['GET_DATA_SUCCESS'] = array(
      "sys_code"=> "200",
      "sys_num"=> "20002",
      "sys_msg"=> array(
          "zh-tw"=> '資料存取成功',
          "zh-cn"=> '资料存取成功',
          "en-us"=> 'Data Request Success'
      )
  );

  /**
   * @apiDefine sucCode_20003
   * @apiSuccess PROCESS_SUCCESS 20003 處理成功
   */
  $config['suc_code']['PROCESS_SUCCESS'] = array(
      "sys_code"=> "200",
      "sys_num"=> "20003",
      "sys_msg"=> array(
          "zh-tw"=> '處理成功',
          "zh-cn"=> '处理成功',
          "en-us"=> 'Process Success'
      )
  );

?>

