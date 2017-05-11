<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wxuser extends Model
{
     public $timestamps = false;

     public static function dataMigrate($openid) {
       $infos = self::where(['openid'=>$openid])->get([
         'openid',
         'nickName',
         'avatarUrl',
         'gender'
       ])->toArray();
       return $infos;
     }
}
