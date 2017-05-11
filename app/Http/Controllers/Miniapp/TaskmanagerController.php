<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Session;
use App\Models\Admin;
use App\Models\Taskmanager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiException;

class TaskmanagerController extends Controller
{
    public function create(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $this->validate($request, [
          'model' => 'required',
          'num' => 'required',
          'title' => 'required',
          'body' => 'required',
          'type' => 'required'
        ]);
        Taskmanager::create($request->all());
        $res = returnCode(true,'任务添加成功','success');
        return response()->json($res);
      } else {
        throw new ApiException('管理员不存在');
      }
    }

    public function show(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));

    }
}
