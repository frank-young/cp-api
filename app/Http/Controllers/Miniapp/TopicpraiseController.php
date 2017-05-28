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
      $result = Topicpraise::praise($openid, $topic_id);  // 点赞操作
      if ($result) {
        Topic::addPraiseNum($topic_id); // 增加点赞数
        $res = returnCode(true,'点赞成功', 'success');
      } else {
        $res = returnCode(false,'点赞失败', 'fail');
      }
      return response()->json($res);
    }

    public function cancel(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $topic_id = $request->input('topic_id');
      $result = Topicpraise::cancelPraise($openid, $topic_id);  // 取消点赞操作
      if ($result) {
        Topic::reducePraiseNum($topic_id); // 减少点赞数
        $res = returnCode(true,'取消点赞成功', 'success');
      } else {
        $res = returnCode(false,'取消点赞失败', 'fail');
      }
      return response()->json($res);
    }

}
