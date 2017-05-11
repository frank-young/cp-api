<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
     public $timestamps = false;
     public static function addData($data, $openid) {
       $task = new Task;
       $task->term = $data->term;
       $task->openid = $data->openid;
       $task->save();
     }
}
