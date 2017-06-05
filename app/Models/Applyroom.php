<?php
namespace App\Models;

use App\Models\Wxuser;
use Illuminate\Database\Eloquent\Model;

class Applyroom extends Model
{
    protected $fillable = [
      'name',
      'openid',
      'phone',
      'wx_id',
      'content',
      'is_agree'
    ];
    // 查询话题所对应的用户
    public function user() {
      return $this->belongsTo('App\Models\Wxuser', 'openid', 'openid');
    }

    public static function agree($openid)
    {
      $applyroom = self::where(['openid'=>$openid])->first();
      $applyroom->is_agree = 1;
      $applyroom->save();
    }

    public static function notAgree($openid)
    {
      $applyroom = self::where(['openid'=>$openid])->first();
      $applyroom->is_agree = 2;
      $applyroom->save();
    }
}
