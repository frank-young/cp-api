<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Applyroom;
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
          unset($value->openid);
          unset($value->user->openid);
        }
        $res = returnCode(true,'查询成功',$applyrooms);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }
}
