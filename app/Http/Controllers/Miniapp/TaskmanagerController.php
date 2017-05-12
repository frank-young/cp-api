<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Session;
use App\Models\Admin;
use App\Models\Taskmanager;
use App\Models\Taskterm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiException;

class TaskmanagerController extends Controller
{
    /*
     * 创建任务
     */
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

    /*
     * 发布任务
     */
    public function publish(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN' || $role == 'HOUSE_OWNER') {
        Taskterm::publishTask(3);  // 发布任务，给每个人添加任务id
        $res = returnCode(true,'任务发布成功','success');
        return response()->json($res);
      } else {
        throw new ApiException('权限不够');
      }
    }
}
