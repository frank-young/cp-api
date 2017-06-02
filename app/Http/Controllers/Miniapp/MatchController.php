<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Infoterm;
use App\Models\Matchterm;
use App\Models\Session;
use App\Models\Wxuser;
use App\Models\Taskterm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchController extends Controller
{
    public function index(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $match = Matchterm::where(['openid'=>$openid])->first();
      if (empty($match)) {
        $res = returnCode(true,'查询成功','匹配未成功');
      } else {
        $wxuser = Wxuser::where(['openid'=>$openid])->firstOrFail();
        $match_openid = $match->first()->match_openid;
        $offset = $match->first()->offset;
        $info = Infoterm::where(['openid'=>$match_openid])->first();
        $info->offset = $offset;
        $info->room_num = $match->first()->room_num;
        $info->self_num = $match->first()->self_num;
        $info->avatarUrl = $wxuser->avatarUrl;
        $info->nickName = $wxuser->nickName;
        $info->age = calcAge($info->birthday);
        $res = returnCode(true,'查询成功',$info);
      }

      return response()->json($res);
    }

    public function attendance(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $match = Matchterm::where(['openid'=>$openid])->first();
      if (empty($match)) {
        $res = returnCode(true,'查询成功','匹配未成功');
      } else {
        $match->attendance = 1;
        $match->save();
        Taskterm::addTask($match, $openid); // 存入本期任务表
        $res = returnCode(true,'查询成功','签到成功');
      }
      return response()->json($res);
    }

    public function attendanceStatus(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $match = Matchterm::where(['openid'=>$openid])->first();
      if (empty($match)) {
        $res = returnCode(true,'查询成功','匹配未成功');
      } else {
        if ($match->attendance == 1) {
            $res = returnCode(true,'查询成功','已经签到成功');
        } else {
            $res = returnCode(false,'查询成功','还未签到');
        }
      }
      return response()->json($res);
    }
}
