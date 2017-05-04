<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Session;
use App\Models\Term;
use App\Models\Questionterm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiException;

class ManagerController extends Controller
{
    public function termStart()
    {
      // $term = new Term;
      $term = Term::where(['id'=>1])->first();
      if($term->status == 0) {
        $term->status = 1;
        $term->term = $term->term + 1;
        $term->save();
        $res = returnCode(true,'开启成功','success');
        return response()->json($res);
      } else {
        throw new ApiException('开启失败，正在报名中');
        return response()->json($res);
      }
    }

    public function termStop()
    {
      $term = Term::where(['id'=>1])->first();
      if($term->status == 1) {
        $term->status = 0;
        $term->save();
        $res = returnCode(true,'关闭成功','success');
        return response()->json($res);
      } else {
        throw new ApiException('关闭失败，报名已经结束');
      }
    }

    public function termStatus(Request $request)
    {
      $openid = Session::getOpenid($request->input('session_key'));
      $term = Term::where(['id'=>1])->first();
      if($term->status == 1) {
        $question = Questionterm::where(['openid' =>$openid])->first();
        if (empty($question)) {
          $res = returnCode(true,'立即报名',1);
        } else {
          $res = returnCode(true,'修改资料',2);
        }
      } else {
        $res = returnCode(false,'匹配查询',0);
      }
      return response()->json($res);
    }

}
