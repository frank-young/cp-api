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
}
