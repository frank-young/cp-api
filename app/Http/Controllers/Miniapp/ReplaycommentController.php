<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Comment;
use App\Models\Topic;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplaycommentController extends Controller
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

    }

    public function update(Request $request)
    {

    }

}
