<?php
namespace App\Models;

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
}
