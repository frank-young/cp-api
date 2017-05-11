<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ApiException;

class Taskterm extends Model
{
     public $timestamps = false;
     public static function addData($data, $openid) {
       $result = self::where(['openid'=>$openid])->first();
       if (empty($result)) {
         $task = new Taskterm;
         $task->term = $data->term;
         $task->openid = $data->openid;
         $task->group_id = create_guid();
         $task->save();
       } else {
         throw new ApiException('记录已经存在');
       }
     }
}
