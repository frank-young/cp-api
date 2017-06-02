<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Session;
use App\Models\Wxuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxuserController extends Controller
{
    // private $appId = 'wx1c426b7c3311c97d';
    // private $appSecret = '3fc1637131d8f9941e85597daeb55e48';

    private $appId = 'wx96f1071d5cdc6142';
    private $appSecret = '955c76a5eaed60ed945da36f435c8e38';

    // login 和 getuserinfo 有相同的地方，为了后期的维护，还是选择了分开来写这两个部分
    public function login(Request $request)
    {
      $wx_session = jscode2session($request->input('code'),$this->appId,$this->appSecret);
      $key_session = create_guid();

      /*
       * 用session存入数据库来验证用户是否登录
       */
      $result = Session::where(['openid'=>$wx_session->openid])->first();
      if (empty($result)) {
       $session = new Session;
       $session->openid = $wx_session->openid;
       $session->save();
      } else {
       $result->session_key = $wx_session->session_key;
       $result->private_session_key = $key_session;
       $result->save();
      }

      $resultWxuser = Wxuser::where(['openid'=>$wx_session->openid])->first();
      if (empty($resultWxuser)) {
        $wxuser = new Wxuser; // 存入用户信息表
        $wxuser->openid = $wx_session->openid;
        $wxuser->save();
      }

      $res = returnCode(true,'成功',$key_session);

      return response()->json($res);
    }

    // 这里为获取用户信息同意后的登录，为主要入口
    public function getuserinfo(Request $request)
    {
      $userinfo = json_decode($request->input('userinfo'));
      $wx_session = jscode2session($request->input('code'),$this->appId,$this->appSecret);
      $key_session = create_guid();

      $result = Session::where(['openid'=>$wx_session->openid])->first();
      if (empty($result)) {
        $session = new Session;
        $session->openid = $wx_session->openid;
        $session->session_key = $wx_session->session_key;
        $session->private_session_key = $key_session;
        $session->save();
      } else {
        $result->session_key = $wx_session->session_key;
        $result->private_session_key = $key_session;
        $result->save();
      }

      $resultWxuser = Wxuser::where(['openid'=>$wx_session->openid])->first();
      if (empty($resultWxuser)) {
        $wxuser = new Wxuser; // 存入用户信息表
        $wxuser->openid = $wx_session->openid;
        $wxuser->nickName = $userinfo->userInfo->nickName;
        $wxuser->avatarUrl = $userinfo->userInfo->avatarUrl;
        $wxuser->gender = $userinfo->userInfo->gender;
        $wxuser->province = $userinfo->userInfo->province;
        $wxuser->city = $userinfo->userInfo->city;
        $wxuser->country = $userinfo->userInfo->country;
        $wxuser->save();
      }

      $res = returnCode(true,'成功',$key_session);

      return response()->json($res);
    }

    public function getSessionKey(Request $request)
    {
      // $openid = Session::getOpenid($request->input('session_key'));
      if (!empty($request->input('session_key'))) {
        $session = Session::where(['private_session_key'=>$request->input('session_key')])->first();
        if (!empty($session->openid)) {
          $res = returnCode(true,'成功',$session->openid);
        } else {
          $res = returnCode(false,'失败','session_key不合法');
        }
      } else {
        $res = returnCode(false,'缺少参数','session_key不能为空');
      }
      return response()->json($res);
    }

}
