<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Info;
use App\Models\Question;
use App\Models\Session;
use App\Models\Boy;
use App\Models\Girl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    public function classify()
    {
        $questions = Question::all();

        foreach ($questions as $key => $value) {
          if ($value->sex == 0) {
            $boy = new Boy;
            $boy->term = $value->term;
            $boy->openid = $value->openid;
            $boy->name = $value->name;
            $boy->sex = $value->sex;
            $boy->extraversion = $value->extraversion;
            $boy->agreeableness = $value->agreeableness;
            $boy->conscientiousness = $value->conscientiousness;
            $boy->neuroticism = $value->neuroticism;
            $boy->openness = $value->openness;
            $boy->save();
          } else {
            $girl = new Girl;
            $girl->term = $value->term;
            $girl->openid = $value->openid;
            $girl->name = $value->name;
            $girl->sex = $value->sex;
            $girl->extraversion = $value->extraversion;
            $girl->agreeableness = $value->agreeableness;
            $girl->conscientiousness = $value->conscientiousness;
            $girl->neuroticism = $value->neuroticism;
            $girl->openness = $value->openness;
            $girl->save();
          }
        }

        $res = returnCode(true,'分类成功','success');
        return response()->json($res);
    }
    public function match()
    {
      $boys = Boy::all();
      $girls = Girl::all();

      foreach ($girls as $key => $value) {
        $match_arr = array();
        $match_data_arr = array();
        foreach ($boys as $k => $v) {
            $extraversion_diff = ($value->extraversion - $v->extraversion) + 1;
            $agreeableness_diff = ($value->agreeableness - $v->agreeableness) + 1;
            $conscientiousness_diff = ($value->conscientiousness - $v->conscientiousness) + 1;
            $neuroticism_diff = ($value->neuroticism - $v->neuroticism) + 1;
            $openness_diff = ($value->openness - $v->openness) + 1;
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
              'name' => $v->name
            ));
        }
        var_dump($match_data_arr);
        foreach ($match_data_arr as $k2 => $v2) {
          if ($v2['offset'] == min($match_arr)) {
            $g = Girl::where(['openid' => $value->openid])->first();
            $g->match_openid = $v2['openid'];
            $g->match_name = $v2['name'];
            $g->save();
            $b = Boy::where(['openid' => $v2['openid']])->first();
            $b->match_openid = $value->openid;
            $b->match_name = $value->name;
            $b->save();
          }
        }

      }
      // $res = returnCode(true,'成功','success');
      // return response()->json($res);
    }
}
