<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Session;
use App\Models\Wxuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxuserController extends Controller
{
    private $appId = 'wx1c426b7c3311c97d';
    private $appSecret = '3fc1637131d8f9941e85597daeb55e48';

    // login 和 getuserinfo 有相同的地方，为了后期的维护，还是选择了分开来写这两个部分
    public function login(Request $request)
    {
      $wx_session = $this->jscode2session($request->input('code'));
      $key_session = $this->create_guid();

      /*
       * 用session存入数据库来验证用户是否登录
       */
      $result = Session::where(['openid'=>$wx_session->openid])->get();
      $session = new Session; // 存入登录验证信息表
      if ($result->isEmpty()) {
        $session->openid = $wx_session->openid;
      } else {
        $session = Session::where(['openid'=>$wx_session->openid])->first();
      }
      $session->session_key = $wx_session->session_key;
      $session->private_session_key = $key_session;
      $session->save();

      $resultWxuser = Wxuser::where(['openid'=>$wx_session->openid])->get();
      if ($resultWxuser->isEmpty()) {
        $wxuser = new Wxuser; // 存入用户信息表
        $wxuser->openid = $wx_session->openid;
        $wxuser->save();
      }

      $res = $this->returnCode(true,'成功',$key_session);

      return response()->json($res);
    }

    public function getuserinfo(Request $request)
    {
      $userinfo = json_decode($request->input('userinfo'));
      $wx_session = $this->jscode2session($request->input('code'));
      $key_session = $this->create_guid();

      $result = Session::where(['openid'=>$wx_session->openid])->get();
      $session = new Session; // 存入登录验证信息表
      if ($result->isEmpty()) {
        $session->openid = $wx_session->openid;
      } else {
        $session = Session::where(['openid'=>$wx_session->openid])->first();
      }
      $session->session_key = $wx_session->session_key;
      $session->private_session_key = $key_session;
      $session->save();

      $resultWxuser = Wxuser::where(['openid'=>$wx_session->openid])->get();
      if ($resultWxuser->isEmpty()) {
        $wxuser = new Wxuser; // 存入用户信息表
        // $wxuser = $userinfo->userInfo;
        $wxuser->openid = $wx_session->openid;
        $wxuser->nickName = $userinfo->userInfo->nickName;
        $wxuser->avatarUrl = $userinfo->userInfo->avatarUrl;
        $wxuser->gender = $userinfo->userInfo->gender;
        $wxuser->province = $userinfo->userInfo->province;
        $wxuser->city = $userinfo->userInfo->city;
        $wxuser->country = $userinfo->userInfo->country;
        $wxuser->save();
      }

      $res = $this->returnCode(true,'成功',$key_session);

      return response()->json($res);
    }

    public function getopenid(Request $request)
    {
      if (!empty($request->input('session_key'))) {
        $session = Session::where(['private_session_key'=>$request->input('session_key')])->first();
        if (!empty($session->openid)) {
          $res = $this->returnCode(true,'成功',$session->openid);
        } else {
          $res = $this->returnCode(false,'失败','session_key不合法');
        }
      } else {
        $res = $this->returnCode(false,'缺少参数','session_key不能为空');
      }
      return response()->json($res);
    }

    /*
     * 向微信服务器发送请求，获取openid, session_key
     */
    public function jscode2session($code)
    {
      $url='https://api.weixin.qq.com/sns/jscode2session?appid='.$this->appId
      .'&secret='.$this->appSecret
      .'&js_code='.$code
      .'&grant_type=authorization_code';

      $json = json_decode(file_get_contents($url));
      return  $json;
    }

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
    public function returnCode($success, $msg, $bizContent)
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
}
