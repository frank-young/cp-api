<?php

function test()
{
    echo "我是自定义函数类库.</br>";
}

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
    $res = [
      "errcode" => 10000,
      "success" => true,
      "msg" => $msg,
      "bizContent" => $bizContent
    ];
  } else {
    $res = [
      "errcode" => 40001,
      "success" => false,
      "msg" => $msg,
      "bizContent" => $bizContent
    ];
  }
  return $res;
}
