<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Comment;
use App\Models\Topic;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function create(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $comment = Comment::create($request->all());
      $comment->topic_id = $request->input('topic_id');
      $comment->openid = $openid;
      if ($comment->save()) {
        Topic::addCommentNum($request->input('topic_id'));
      }
      $res = returnCode(true,'评论成功','success');
      return response()->json($res);
    }

    public function index(Request $request)
    {
      // $openid = Session::getOpenid($request->input('session_key'));
      $topic_id = $request->input('topic_id');
      $offset = $request->input('offset');
      $limit = $request->input('limit');
      $comments = Comment::with('user')
        ->where(['topic_id' => $topic_id])
        ->with('praise')
        ->offset($offset)
        ->limit($limit)
        ->orderBy('praise_num', 'desc')
        ->get();
      foreach ($comments as $key => $value) {
        $value->date_format = formatDate($value->created_at);
        unset($value->openid);
        unset($value->user->openid);
      }
      $res = returnCode(true,'查询成功', $comments);
      return response()->json($res);
    }

    public function show(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $id = $request->input('id');
      $comment = Comment::with('user')
        ->where(['id' => $id])
        ->with('praise')
        ->first();
      $comment->date_format = formatDate($comment->created_at);
      unset($comment->openid);
      unset($comment->user->openid);
      $res = returnCode(true,'查询成功', $comment);
      return response()->json($res);
    }

}
