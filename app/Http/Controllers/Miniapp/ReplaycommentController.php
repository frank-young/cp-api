<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Replaycomment;
use App\Models\Comment;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplaycommentController extends Controller
{

    public function create(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $replaycomment = Replaycomment::create($request->all());
      $replaycomment->openid = $openid;
      $replaycomment->save();
      if ($replaycomment->save()) {
        Comment::addReplayNum($request->input('comment_id'));
      }
      $res = returnCode(true,'评论成功','success');
      return response()->json($res);
    }
}
