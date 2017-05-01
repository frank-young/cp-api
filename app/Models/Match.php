<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
     public $timestamps = false;

     public static function addData($data) {
       $match = new Match; // 整体匹配表

       $match->term = $data->term;
       $match->openid = $data->openid;
       $match->name = $data->name;
       $match->sex = $data->sex;
       $match->match_openid = $data->match_openid;
       $match->match_name = $data->match_name;
       $match->match_sex = $data->match_sex;
       $match->offset = $data->offset;

       $match->save();
     }
}
