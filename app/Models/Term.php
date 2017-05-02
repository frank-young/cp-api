<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ApiException;

class Term extends Model
{
     public $timestamps = false;
     public static function getTerm() {
       $term = self::where(['id'=>1,'status'=>1])->first();
       if(empty($term)) {
         throw new ApiException('本期报名已经结束，请查看匹配');
       } else {
         return $term->term;
       }

     }
}
