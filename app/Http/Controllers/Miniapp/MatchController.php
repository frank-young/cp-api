<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Infoterm;
use App\Models\Matchterm;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchController extends Controller
{
    public function index(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $match = Matchterm::where(['openid'=>$openid]);
      if ($match->get()->isEmpty()) {
        $res = returnCode(true,'查询成功','匹配未成功');
      } else {
        $match_openid = $match->first()->match_openid;
        $offset = $match->first()->offset;
        $info = Infoterm::where(['openid'=>$match_openid])->first();
        $info->offset = $offset;
        $res = returnCode(true,'查询成功',$info);
      }

      return response()->json($res);
    }

    public function create(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {

    }
}
