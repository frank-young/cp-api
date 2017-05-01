<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Info;
use App\Models\Question;
use App\Models\Questionterm;
use App\Models\Session;
use App\Models\Boy;
use App\Models\Girl;
use App\Models\Match;
use App\Models\Matchterm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    public function classify()
    {
        Girl::clearData();
        Boy::clearData();
        Matchterm::clearData(); // 清空本期匹配数据
        Questionterm::addData();

        $res = returnCode(true,'分类成功','success');
        return response()->json($res);
    }
    public function matchGirl()
    {
      Girl::matchingAlgorithm();

      $res = returnCode(true,'成功','success');
      return response()->json($res);
    }

    public function matchBoy()
    {
      Boy::matchingAlgorithm();

      $res = returnCode(true,'成功','success');
      return response()->json($res);
    }

    public function match()
    {
      $start_time=microtime(true);

      Girl::clearData();
      Boy::clearData();
      Matchterm::clearData(); // 清空本期匹配数据
      Questionterm::addData();
      
      while (Girl::all()->count() != 0 && Boy::all()->count() != 0) {
        Girl::matchingAlgorithm();
        Boy::matchingAlgorithm();

        $girls = Girl::all();
        foreach ($girls as $girl) {
          $boys = Boy::all();
          foreach ($boys as $boy) {
            if ($girl->match_openid == $boy->openid && $boy->match_openid == $girl->openid) {
              Match::addData($girl);
              Matchterm::addData($girl);

              Match::addData($boy);
              Matchterm::addData($boy);

              Girl::where(['openid' => $girl->openid])->delete();
              Boy::where(['openid' => $boy->openid])->delete();
            }
          }
        }
      }
      $end_time=microtime(true);

      $total_time = number_format($end_time - $start_time, 2);

      $res = returnCode(true,'匹配成功',['time' => $total_time.'秒']);
      return response()->json($res);
    }
}
