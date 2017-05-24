<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Comment;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function create(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $comment = Comment::create($request->all());
      $comment->topic_id = $request->input('id');
      $comment->openid = $openid;
      $comment->save();
      $res = returnCode(true,'评论成功','success');
      return response()->json($res);
    }

    public function update(Request $request)
    {

    }

}
