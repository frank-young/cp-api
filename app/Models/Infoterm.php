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
      'area_matching',
      'age_matching'
    ];
    //  public $timestamps = false;
}
