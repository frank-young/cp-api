<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Applyroom;
use App\Models\Wxuser;
use App\Models\Admin;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApplyroomController extends Controller
{

    public function create(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $applyroom = Applyroom::create($request->all());
      $applyroom->openid = $openid;
      $applyroom->save();

      $res = returnCode(true,'提交申请成功','success');
      return response()->json($res);
    }

    /*
     *  申请房主列表
     */
    public function index(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $applyrooms = Applyroom::with('user')
        ->offset($offset)
        ->limit($limit)
        ->orderBy('updated_at', 'desc')->get();

        foreach ($applyrooms as $key => $value) {
          // unset($value->openid);
          unset($value->user->openid);
        }
        $res = returnCode(true,'查询成功',$applyrooms);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    /*
     *  同意成为房主
     */
    public function agree(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      $apply_openid = $request->input('openid');
      if ($role == 'ADMIN') {
        $wxuser = Wxuser::dataMigrate($apply_openid); // 取出数据
        Admin::addOne($wxuser, $apply_openid); // 存入数据
        Admin::setRole('HOUSE_OWNER', $apply_openid); // 添加权限，管理员权限
        Applyroom::agree($apply_openid);  // 同意操作
        $res = returnCode(true,'修改成功','success');
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    /*
     *  拒绝成为房主
     */
    public function notAgree(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      $apply_openid = $request->input('openid');
      if ($role == 'ADMIN') {
        Applyroom::agree($apply_openid);  //拒绝操作

        $res = returnCode(true,'修改成功','success');
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    /*
     *  获取当前状态
     */
    public function status(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $applyroom = Applyroom::where(['openid'=>$openid])->first();
      if (!empty($applyroom)) {
        $res = returnCode(true,'获取成功',$applyroom);
      } else {
        $res = returnCode(false,'未申请过房主','not room-owner');
      }
      return response()->json($res);
    }
}
