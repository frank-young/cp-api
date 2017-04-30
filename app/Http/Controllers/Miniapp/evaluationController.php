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

        Questionterm::chunk(200, function ($questionterms) {
          foreach ($questionterms as $questionterm) {
            if ($questionterm->sex == 0) {
              Boy::addData($questionterm);
            } else {
              Girl::addData($questionterm);
            }
          }
        });

        $res = returnCode(true,'分类成功','success');
        return response()->json($res);
    }
    public function match()
    {
      Girl::clearData();
      Boy::clearData();

      Questionterm::chunk(200, function ($questionterms) {
        foreach ($questionterms as $questionterm) {
          if ($questionterm->sex == 0) {
            Boy::addData($questionterm);
          } else {
            Girl::addData($questionterm);
          }
        }
      });

      Matchterm::clearData();

      $girls = Girl::all();

      foreach ($girls as $key => $value) {
        $match_arr = array();
        $match_data_arr = array();

        $boys = Boy::all();

        foreach ($boys as $k => $v) {
            $extraversion_diff = ($value->extraversion - $v->extraversion);
            $agreeableness_diff = ($value->agreeableness - $v->agreeableness);
            $conscientiousness_diff = ($value->conscientiousness - $v->conscientiousness);
            $neuroticism_diff = ($value->neuroticism - $v->neuroticism);
            $openness_diff = ($value->openness - $v->openness);
            $offcenter = $extraversion_diff * $extraversion_diff +
                         $agreeableness_diff * $agreeableness_diff +
                         $conscientiousness_diff * $conscientiousness_diff +
                         $neuroticism_diff * $neuroticism_diff +
                         $openness_diff * $openness_diff;

            $offcenter_sqrt = sqrt($offcenter);
            array_push($match_arr, $offcenter_sqrt);
            array_push($match_data_arr, array(
              'offset' => $offcenter_sqrt,
              'openid' => $v->openid,
              'name' => $v->name,
              'sex' => $v->sex
            ));
        }

        foreach ($match_data_arr as $k2 => $v2) {
          if ($v2['offset'] == min($match_arr)) {
            $match = new Match; // 整体匹配表
            $matchterm = new Matchterm;

            $matchterm->openid = $match->openid = $value->openid;
            $matchterm->name = $match->name = $value->name;
            $matchterm->sex = $match->sex = $value->sex;

            $matchterm->match_openid = $match->match_openid = $v2['openid'];
            $matchterm->match_name = $match->match_name = $v2['name'];
            $matchterm->match_sex = $match->match_sex = $v2['sex'];
            $match->save();
            $matchterm->save();

            Girl::where(['openid' => $value->openid])->delete();
            Boy::where(['openid' => $v2['openid']])->delete();
          }
        }
      }

      $res = returnCode(true,'成功','success');
      return response()->json($res);
    }
}
