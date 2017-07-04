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
          // 'model' => 'required',
          'num' => 'required',
          'title' => 'required',
          'body' => 'required',
          // 'type' => 'required'
        ]);
        Taskmanager::create($request->all());
        $res = returnCode(true,'任务添加成功','success');
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    /*
     * 任务列表
     */
    public function index(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $tasks = Taskmanager::offset($offset)
        ->limit($limit)
        ->orderBy('num')->get();

        $res = returnCode(true,'任务列表查询成功',$tasks);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    public function update(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $id = $request->input('id');
        $task = Taskmanager::where(['id' => $id])->first();
        $task->title = $request->input('title');
        $task->num = $request->input('num');
        $task->body = $request->input('body');

        $task->save();
        $res = returnCode(true,'创建房间成功',$task);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    public function show(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $id = $request->input('id');
        $task = Taskmanager::where(['id' => $id])->first();

        $res = returnCode(true,'查询成功',$task);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
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
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }
}
