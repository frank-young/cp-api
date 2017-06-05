<?php
namespace App\Models;

use App\Models\Wxuser;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
      'name',
      'num',
      'wx_id',
      'qrcode_path'
    ];

}
