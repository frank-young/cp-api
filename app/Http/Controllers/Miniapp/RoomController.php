<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Session;
use App\Models\Admin;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function create(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $room= Room::create($request->all());

        $res = returnCode(true,'创建房间成功',$room);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    public function update(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $id = $request->input('id');
        $room = Room::where(['id' => $id])->first();
        $room->name = $request->input('name');
        $room->num = $request->input('num');
        $room->wx_id = $request->input('wx_id');
        $room->qrcode_path = $request->input('qrcode_path');

        $room->save();
        $res = returnCode(true,'创建房间成功',$room);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    public function index(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $rooms = Room::offset($offset)
        ->limit($limit)
        ->orderBy('num')->get();

        $res = returnCode(true,'查询成功',$rooms);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    public function show(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $role = Admin::getRole($openid);
      if ($role == 'ADMIN') {
        $id = $request->input('id');
        $room = Room::where(['id' => $id])->first();
        $room->qrcode_path = json_decode($room->qrcode_path);
        $res = returnCode(true,'查询成功',$room);
      } else {
        $res = returnCode(false,'权限不够','fail');
      }
      return response()->json($res);
    }

    /*
     *  根据房间编号查询房间信息
     */
    public function num(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $num = $request->input('num');
      $room = Room::where(['num' => $num])->first();
      if (!empty($room)) {
        $room->qrcode_path = json_decode($room->qrcode_path);
        $res = returnCode(true,'查询房间信息成功',$room);
      } else {
        $res = returnCode(true,'暂无房间信息','fail');
      }
      return response()->json($res);
    }
}
