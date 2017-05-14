<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Session;
use App\Models\Taskmanager;
use App\Models\Taskahead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskaheadController extends Controller
{
    /*
     * 完成每一次任务.
     */
    public function create(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $group_id = $request->input('group_id');
      $term = $request->input('term');
      $taskmanager_id = $request->input('taskmanager_id');
      $result = Taskahead::where([
        'group_id' => $group_id,
        'taskmanager_id' => $taskmanager_id,
        'term' => $term])->first();
      if (empty($result)) {
        $task = Taskahead::create($request->all());
        $task->openid = $openid;
        $task->is_complete = 1;
        $task->save();
      } else {
        $result->image_path = $request->input('image_path');
        $result->save();
      }

      $res = returnCode(true,'完成任务成功', 'success');
      return response()->json($res);
    }

    /*
     * 获取完成任务的图片信息
     */
    public function show(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $group_id = $request->input('group_id');
      $term = $request->input('term');
      $taskmanager_id = $request->input('taskmanager_id');
      $result = Taskahead::where([
        'group_id' => $group_id,
        'taskmanager_id' => $taskmanager_id,
        'term' => $term])->first();
      if (!empty($result)) {
        $result->image_path = json_decode($result->image_path);
        $res = returnCode(true,'获取完成任务成功', $result);
        return response()->json($res);
      } else {
        $res = returnCode(false,'未完成任务', 'fail');
        return response()->json($res);
      }
    }

}
