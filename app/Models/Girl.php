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
}
