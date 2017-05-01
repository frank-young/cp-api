<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
     public $timestamps = false;

     public static function getOpenid($session_key) {
       $session = Session::where(['private_session_key'=>$session_key])->first();
       return $session->openid;
     }
}
