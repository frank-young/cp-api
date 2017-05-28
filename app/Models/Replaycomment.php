<?php
namespace App\Models;

use App\Models\Wxuser;
use Illuminate\Database\Eloquent\Model;

class Replaycomment extends Model
{
    protected $fillable = [
      'comment_id',
      'content',
      'praise_num',
      'replay_num'
    ];
    // 查询话题所对应的用户
    public function user() {
      return $this->belongsTo('App\Models\Wxuser', 'openid', 'openid');
    }

}
