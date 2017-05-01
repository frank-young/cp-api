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
use App\Models\Infoterm;
use App\Models\Usercache;
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
    public function matchMove()
    {
      Questionterm::clearData();
      $infos = Question::where(['term'=>0])->get([
        'term',
        'openid',
        'name',
        'sex',
        'city',
        'extraversion',
        'agreeableness',
        'conscientiousness',
        'neuroticism',
        'openness',
        'question_score_json',
        'area_matching'
      ])->toArray();
      Questionterm::addAll($infos);
      $res = returnCode(true,'成功','success');
      return response()->json($res);
    }

    public function matchCity()
    {
      $start_time=microtime(true);
      $index = 0;
      Matchterm::clearData();
      Usercache::clearData();
      $cities = Infoterm::getCity();
      /*
       * 同城市匹配
       */
      foreach ($cities as $city) {
        $infos = Questionterm::where(['city'=>$city, 'area_matching'=>0])->get([
          'term',
          'openid',
          'name',
          'sex',
          'city',
          'extraversion',
          'agreeableness',
          'conscientiousness',
          'neuroticism',
          'openness'
        ])->toArray();
        Usercache::addAll($infos);
        Girl::clearData();
        Boy::clearData();
        $users = Usercache::addData();
        while (Girl::all()->count() != 0 && Boy::all()->count() != 0) {
          Girl::matchingAlgorithm();
          Boy::matchingAlgorithm();

          $girls = Girl::cursor();
          foreach ($girls as $girl) {
            $boys = Boy::cursor();
            foreach ($boys as $boy) {
              $index++;
              if ($girl->match_openid == $boy->openid && $boy->match_openid == $girl->openid) {
                Match::addData($girl);
                Matchterm::addData($girl);

                Match::addData($boy);
                Matchterm::addData($boy);

                Girl::where(['openid' => $girl->openid])->delete();
                Boy::where(['openid' => $boy->openid])->delete();
                Questionterm::where(['openid'=>$girl->openid])->delete();
                Questionterm::where(['openid'=>$boy->openid])->delete();
              }
            }
          }
        }

        Usercache::clearData();
      }

      $end_time=microtime(true);
      $total_time = number_format($end_time - $start_time, 2);

      $res = returnCode(true,'成功', ['time' => $total_time.'秒','per'=>$index]);
      return response()->json($res);
    }

    public function match()
    {
      $start_time=microtime(true);

      Girl::clearData();
      Boy::clearData();
      // Matchterm::clearData(); // 清空本期匹配数据
      Questionterm::addData();

      while (Girl::all()->count() != 0 && Boy::all()->count() != 0) {
        Girl::matchingAlgorithm();
        Boy::matchingAlgorithm();

        $girls = Girl::cursor();
        foreach ($girls as $girl) {
          $boys = Boy::cursor();
          foreach ($boys as $boy) {
            if ($girl->match_openid == $boy->openid && $boy->match_openid == $girl->openid) {
              Match::addData($girl);
              Matchterm::addData($girl);

              Match::addData($boy);
              Matchterm::addData($boy);

              Girl::where(['openid' => $girl->openid])->delete();
              Boy::where(['openid' => $boy->openid])->delete();
              Questionterm::where(['openid'=>$girl->openid])->delete();
              Questionterm::where(['openid'=>$boy->openid])->delete();
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
