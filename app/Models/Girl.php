<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Girl extends Model
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
       $girl = new Girl;
       $girl->term = $data->term;
       $girl->openid = $data->openid;
       $girl->name = $data->name;
       $girl->sex = $data->sex;
       $girl->extraversion = $data->extraversion;
       $girl->agreeableness = $data->agreeableness;
       $girl->conscientiousness = $data->conscientiousness;
       $girl->neuroticism = $data->neuroticism;
       $girl->openness = $data->openness;
       $girl->save();
     }

     public static function matchingAlgorithm() {
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

             $girl = Girl::where(['openid' => $value->openid])->first();
             $girl->match_openid = $v2['openid'];
             $girl->match_name = $v2['name'];
             $girl->match_sex = $v2['sex'];
             $girl->offset = $v2['offset'];
             $girl->save();
           }
         }
       }
     }
}
