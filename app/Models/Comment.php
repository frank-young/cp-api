<?php
namespace App\Models;

use App\Models\Wxuser;
use App\Models\Replaycomment;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
      'topic_id',
      'content',
      'praise_num',
      'replay_num',
      'offset',
      'limit'
    ];
    // 查询评论所对应的用户
    public function user() {
      return $this->belongsTo('App\Models\Wxuser', 'openid', 'openid');
    }

    // 评论增加回复数
    static public function addReplayNum($id) {
      $res = self::where(['id' => $id])->first();
      $res->replay_num = $res->replay_num + 1;
      $res->save();
    }
}
