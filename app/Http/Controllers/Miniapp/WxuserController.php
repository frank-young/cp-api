<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Wxuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxuserController extends Controller
{
    public function login(Request $request)
    {
        $wx_session = $this->jscode2session($request->code);
        $key_session = $this->create_guid();

        $request->session()->put($key_session, $wx_session->openid.$wx_session->session_key);
        // session([$key_session=>$wx_session->openid.$wx_session->session_key]);
        // session(['key' => 'value']);

        $data = [
          "errcode" => 10000,
          "success" => true,
          "bizContent" => $key_session
        ];

        return response()->json($data);
        // oCKTq0HbLLgM6fpEqIncxGrESaek
        // FADr0CUYMHfBkLlee/0LNw==
    }

    /*
     * 向微信服务器发送请求，获取openid, session_key
     */
    public function jscode2session($code)
    {
      $appId = 'wx1c426b7c3311c97d';
      $appSecret = '3fc1637131d8f9941e85597daeb55e48';

      $url='https://api.weixin.qq.com/sns/jscode2session?appid='.$appId
      .'&secret='.$appSecret
      .'&js_code='.$code
      .'&grant_type=authorization_code';

      $json = json_decode(file_get_contents($url));
      return  $json;
    }

    /*
     * 生成第三方session, 并且存储
     */
    // public function 3rd_session($code)
    // {
    //
    // }

    /*
     * 生成uuid
     */
    public function create_guid($namespace = '') {
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
      $guid = '{' .
              substr($hash,  0,  8) .
              '-' .
              substr($hash,  8,  4) .
              '-' .
              substr($hash, 12,  4) .
              '-' .
              substr($hash, 16,  4) .
              '-' .
              substr($hash, 20, 12) .
              '}';
      return $guid;
    }

}
