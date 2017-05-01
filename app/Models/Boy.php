<?php
namespace App\Models;

use App\Models\Girl;
use Illuminate\Database\Eloquent\Model;

class Boy extends Model
{
     public $timestamps = false;

     public static function clearData() {
       self::chunk(200, function ($datas) {
         foreach ($datas as $data) {
           self::find($data->id)->delete();
         }
       });
     }

     public static function addData($data) {
       $boy = new Boy;
       $boy->term = $data->term;
       $boy->openid = $data->openid;
       $boy->name = $data->name;
       $boy->sex = $data->sex;
       $boy->extraversion = $data->extraversion;
       $boy->agreeableness = $data->agreeableness;
       $boy->conscientiousness = $data->conscientiousness;
       $boy->neuroticism = $data->neuroticism;
       $boy->openness = $data->openness;
       $boy->save();
     }

     public static function matchingAlgorithm() {
       $boys = Boy::all();
       foreach ($boys as $key => $value) {
         $match_arr = array();
         $match_data_arr = array();
         $girls = Girl::all();
         foreach ($girls as $k => $v) {
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

             $boy = Boy::where(['openid' => $value->openid])->first();
             $boy->match_openid = $v2['openid'];
             $boy->match_name = $v2['name'];
             $boy->match_sex = $v2['sex'];
             $boy->offset = $v2['offset'];
             $boy->save();
           }
         }
       }
     }
}
