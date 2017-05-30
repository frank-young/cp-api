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
      $res = returnCode(true,'回复成功','success');
      return response()->json($res);
    }

    public function index(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $comment_id = $request->input('comment_id');
      $offset = $request->input('offset');
      $limit = $request->input('limit');
      $replayComments = Replaycomment::with('user')
        ->where(['comment_id' => $comment_id])
        ->offset($offset)
        ->limit($limit)
        ->orderBy('updated_at', 'desc')
        ->get();
      $res = returnCode(true,'查询成功',$replayComments);
      return response()->json($res);
    }
}
