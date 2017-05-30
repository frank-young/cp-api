<?php
namespace App\Models;

use App\Models\Wxuser;
use App\Models\Replaycomment;
use App\Models\Commentpraise;
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
    // 查询点赞所对应的用户
    public function praise() {
      $result = $this->belongsTo('App\Models\Commentpraise', 'id', 'comment_id');
      return $result;
    }

    // 评论增加回复数
    static public function addReplayNum($id) {
      $res = self::where(['id' => $id])->first();
      $res->replay_num = $res->replay_num + 1;
      $res->save();
    }

    // 增加点赞数
    static public function addPraiseNum($id) {
      $res = self::where(['id' => $id])->first();
      $res->praise_num = $res->praise_num + 1;
      $res->save();
    }

    // 减少点赞数
    static public function reducePraiseNum($id) {
      $res = self::where(['id' => $id])->first();
      $res->praise_num = $res->praise_num - 1;
      $res->save();
    }
}
