<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Topic;
use App\Models\Topicpraise;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicpraiseController extends Controller
{

    public function status(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $topic_id = $request->input('topic_id');
      $topicpraise = Topicpraise::where(['topic_id' => $topic_id, 'openid' => $openid])->first();
      if (!empty($topicpraise)) {
        $topicpraise = ['praise_status' => 1];
      } else {
        $topicpraise = ['praise_status' => 0];
      }
      $res = returnCode(true,'查询成功', $topicpraise);
      return response()->json($res);
    }

    public function agree(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $topic_id = $request->input('topic_id');
      $topicpraise = Topicpraise::where(['topic_id' => $topic_id, 'openid' => $openid])->first();

      $res = returnCode(true,'查询成功', $topicpraise);
      return response()->json($res);
    }

    public function cancel(Request $request)
    {

    }

}
