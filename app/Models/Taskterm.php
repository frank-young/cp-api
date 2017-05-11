<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ApiException;

class Taskterm extends Model
{
     public $timestamps = false;
     /*
      * 签到成功，添加任务信息
      */
     public static function addTask($data, $openid) {
       $result = self::where(['openid'=>$openid])->first();
       if (empty($result)) {
         $task = new Taskterm;
         $task->term = $data->term;
         $task->openid = $data->openid;
         $task->room_num = $data->room_num;
         $task->group_id = create_guid();
         $task->save();
       } else {
         throw new ApiException('记录已经存在');
       }
     }
     /*
      * 发布任务
      */
     public static function publishTask(Int $id) {
       $datas = self::cursor();
       foreach ($datas as $data) {
         $task = self::find($data->id)->first();
         $task_arr = (array)json_decode($task->task_arr);
         array_push($task_arr, $id);
         $task->task_arr = json_encode($task_arr);
         $task->save();
       }
     }
}
