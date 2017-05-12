<?php
/*
 * 利用session换取openid
 */
function getopenid(Request $request,Session $session)
{
    if ($request->has('session_key')) {
        $result = $session::where(['private_session_key'=>$request->input('session_key')])->first();
        if (!empty($result->openid)) {
            $res = returnCode(true,'成功',$session->openid);
        } else {
            $res = returnCode(false,'失败','session_key不合法');
        }
    } else {
            $res = returnCode(false,'缺少参数','session_key不能为空');
    }
    return $res;
}

/*
 * 向微信服务器发送请求，获取openid, session_key
 */
function jscode2session($code,$appId,$appSecret)
{
  $url='https://api.weixin.qq.com/sns/jscode2session?appid='.$appId
  .'&secret='.$appSecret
  .'&js_code='.$code
  .'&grant_type=authorization_code';

  $json = json_decode(file_get_contents($url));
  return  $json;
}

/*
 * 生成uuid
 */
function create_guid($namespace = '') {
  static $guid = '';
  $uid = uniqid("", true);
  $data = $namespace;
  $data .= $_SERVER['REQUEST_TIME'];
  $data .= $_SERVER['HTTP_USER_AGENT'];
  // $data .= $_SERVER['LOCAL_ADDR'];
  // $data .= $_SERVER['LOCAL_PORT'];
  $data .= $_SERVER['REMOTE_ADDR'];
  $data .= $_SERVER['REMOTE_PORT'];
  $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
  $guid = '' .
          substr($hash,  0,  8) .
          '-' .
          substr($hash,  8,  4) .
          '-' .
          substr($hash, 12,  4) .
          '-' .
          substr($hash, 16,  4) .
          '-' .
          substr($hash, 20, 12) .
          '';
  return $guid;
}

// 错误代码返回写法尝试
function returnCode($success, $msg, $bizContent)
{
  $res = [];
  if ($success == true) {
    if (!empty($bizContent['openid'])) {
      unset($bizContent['openid']);
    }
    $res = [
      "status_code" => 10000,
      "success" => true,
      "message" => $msg,
      "bizContent" => $bizContent
    ];
  } else {
    $res = [
      "status_code" => 40001,
      "success" => false,
      "message" => $msg,
      "bizContent" => $bizContent
    ];
  }
  return $res;
}

/*
 * 获取五大人格每个属性的值
 */
function getBigFiveSum($questions_data)
{
  $extraversion = 0;
  $agreeableness = 0;
  $conscientiousness = 0;
  $neuroticism = 0;
  $openness = 0;

  foreach ($questions_data as $key => $value) {
    if ($key == 1 || $key == 6 || $key == 11 || $key == 16 || $key == 21 || $key == 26 || $key == 31 || $key == 36) {
      $extraversion += $value;
    } else if($key == 2 || $key == 7 || $key == 12 || $key == 17 || $key == 22 || $key == 27 || $key == 32 || $key == 37 || $key == 42) {
      $agreeableness += $value;
    } else if($key == 3 || $key == 8 || $key == 13 || $key == 18 || $key == 23 || $key == 28 || $key == 33 || $key == 38 || $key == 43) {
      $conscientiousness += $value;
    } else if($key == 4 || $key == 9 || $key == 14 || $key == 19 || $key == 24 || $key == 29 || $key == 34 || $key == 39) {
      $neuroticism += $value;
    } else if($key == 5 || $key == 10 || $key == 15 || $key == 20 || $key == 25 || $key == 30 || $key == 35 || $key == 40 || $key == 41 || $key == 44) {
      $openness += $value;
    }
  }
  return array(
    'extraversion' => $extraversion,
    'agreeableness' => $agreeableness,
    'conscientiousness' => $conscientiousness,
    'neuroticism' => $neuroticism,
    'openness' => $openness
  );
}
