<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
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
}
