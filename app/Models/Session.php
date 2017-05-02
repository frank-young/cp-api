<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ApiException;

class Session extends Model
{
     public $timestamps = false;

     public static function getOpenid($session_key) {
       if ($session_key) {
         $result = self::where(['private_session_key'=>$session_key])->first();
         if (!empty($result->openid)) {
           $res = $result->openid;
         } else {
           $res = 'session_key不合法';
           throw new ApiException($res);
         }
       } else {
         $res = 'session_key不能为空';
         throw new ApiException($res);
       }
       return $res;
     }
}
