<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infoterm extends Model
{
    protected $fillable = [
      'session_key',
      'name',
      'phone',
      'sex',
      'birthday',
      'constellation',
      'province',
      'city',
      'wechat_id',
      'school',
      'hobby',
      'dislike',
      'evaluate',
      'province_index',
      'city_index'
    ];
    //  public $timestamps = false;

    /*
     * 获取本期的城市数组
     */
    public static function getCity () {
      $arr = array();
      foreach (self::cursor() as $value) {
        array_push($arr, $value->city);
      }
      $arr = array_unique($arr);
      return $arr;
    }
}
