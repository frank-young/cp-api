<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Topic;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    public function create(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'description' => 'required',
        'body' => 'required'
      ]);
      $openid = Session::getOpenid($request->input('session_key'));
      $topic = Topic::create($request->all());
      $topic->openid = $openid;
      $topic->save();
      $res = returnCode(true,'话题发布成功','success');
      return response()->json($res);
    }

    public function index(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $offset = $request->input('offset');
      $limit = $request->input('limit');
      $topics = Topic::with('user')
      ->offset($offset)
      ->limit($limit)
      ->orderBy('updated_at', 'desc')->get();

      foreach ($topics as $key => $value) {
        $value->thumbnail_pic = json_decode($value->thumbnail_pic);
        $value->date_format = formatDate($value->created_at);
        unset($value->openid);
        unset($value->user->openid);
      }

      $res = returnCode(true,'查询成功', $topics);
      return response()->json($res);
    }

    public function show(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $id = $request->input('id');
      $topic = Topic::where(['id' => $id])->with('user')->first();
      $topic->thumbnail_pic = json_decode($topic->thumbnail_pic);
      $topic->image_path = json_decode($topic->image_path);
      $topic->date_format = formatDate($topic->created_at);
      unset($topic->openid);
      unset($topic->user->openid);
      $res = returnCode(true,'查询成功', $topic);
      return response()->json($res);
    }

}
