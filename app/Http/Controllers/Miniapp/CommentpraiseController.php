<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Topic;
use App\Models\Commentpraise;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentpraiseController extends Controller
{
    public function status(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $comment_id = $request->input('comment_id');
      $topicpraise = Commentpraise::where(['comment_id' => $comment_id, 'openid' => $openid])->first();
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
      $comment_id = $request->input('comment_id');
      $result = Commentpraise::praise($openid, $comment_id);  // 点赞操作
      if ($result) {
        Topic::addPraiseNum($comment_id); // 增加点赞数
        $res = returnCode(true,'点赞成功', 'success');
      } else {
        $res = returnCode(false,'点赞失败', 'fail');
      }
      return response()->json($res);
    }

    public function cancel(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $comment_id = $request->input('comment_id');
      $result = Commentpraise::cancelPraise($openid, $comment_id);  // 取消点赞操作
      if ($result) {
        Topic::reducePraiseNum($comment_id); // 减少点赞数
        $res = returnCode(true,'取消点赞成功', 'success');
      } else {
        $res = returnCode(false,'取消点赞失败', 'fail');
      }
      return response()->json($res);
    }

}
