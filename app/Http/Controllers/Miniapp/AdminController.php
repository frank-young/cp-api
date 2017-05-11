<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Session;
use App\Models\Wxuser;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function create(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $wxuser = Wxuser::dataMigrate($openid); // 取出数据
      Admin::addOne($wxuser, $openid); // 存入数据
      Admin::setRole('ADMIN', $openid); // 添加权限，管理员权限

      $res = returnCode(true,'添加成功','success');
      return response()->json($res);
    }
}
