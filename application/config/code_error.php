<?php 

  // 主要放置所有的錯誤碼與預設回應，未來可以自動加載到各個編輯器。

  /**
   * @apiDefine errCodeExample
   * @apiErrorExample {json} Response-Example:
   * {
   *      "sys_code": "回應編號",
   *      "sys_num": "錯誤編號",
   *      "sys_msg": "錯誤訊息"
   * }
   */

  /**
   * @apiDefine errCode_40001
   * @apiError MISSING_DATA 40001 資料不足
   */
  $config['err_code']['MISSING_DATA'] = array(
      "sys_code"=> "000",
      "sys_num"=> "40001",
      "sys_msg"=> array(
          "zh-tw"=> '資料不足',
          "zh-cn"=> '资料不足',
          "en-us"=> 'Missing Data'
      )
  );

  /**
   * @apiDefine errCode_40002
   * @apiError DATA_FAIL 40002 資料位置存取錯誤
   */
  $config['err_code']['DATA_FAIL'] = array(
      "sys_code"=> "500",
      "sys_num"=> "40002",
      "sys_msg"=> array(
          "zh-tw"=> '資料位置存取錯誤',
          "zh-cn"=> '资料位置存取错误',
          "en-us"=> 'Data Request Fail'
      )
  );

?>

