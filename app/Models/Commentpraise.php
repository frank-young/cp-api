<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentpraise extends Model
{
  // 点赞操作
  static public function praise ($openid, $comment_id) {
    $topicpraise = self::where(['comment_id' => $comment_id, 'openid' => $openid])->first();
    if (empty($topicpraise)) {
      $praise = new Commentpraise;
      $praise->praise_status = 1;
      $praise->openid = $openid;
      $praise->comment_id = $comment_id;
      $praise->save();
      return true;
    } else {
      return false;
    }
  }
  // 取消点赞操作
  static public function cancelPraise ($openid, $comment_id) {
    $topicpraise = self::where(['comment_id' => $comment_id, 'openid' => $openid])->first();
    if (empty($topicpraise)) {
      return false;
    } else {
      $topicpraise->delete();
      return true;
    }
  }
}
