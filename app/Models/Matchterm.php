<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matchterm extends Model
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
       $matchterm = new Matchterm; // 整体匹配表

       $matchterm->term = $data->term;
       $matchterm->openid = $data->openid;
       $matchterm->name = $data->name;
       $matchterm->sex = $data->sex;
       $matchterm->match_openid = $data->match_openid;
       $matchterm->match_name = $data->match_name;
       $matchterm->match_sex = $data->match_sex;
       $matchterm->offset = $data->offset;

       $matchterm->save();
     }
}
