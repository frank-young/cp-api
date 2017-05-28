<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topicpraise extends Model
{
  // 点赞操作
  static public function praise ($openid, $topic_id) {
    $topicpraise = self::where(['topic_id' => $topic_id, 'openid' => $openid])->first();
    if (empty($topicpraise)) {
      $praise = new Topicpraise;
      $praise->praise_status = 1;
      $praise->openid = $openid;
      $praise->topic_id = $topic_id;
      $praise->save();
      return true;
    } else {
      // $topicpraise->praise_status = 1;
      // $topicpraise->save();
      return false;
    }
  }
  // 取消点赞操作
  static public function cancelPraise ($openid, $topic_id) {
    $topicpraise = self::where(['topic_id' => $topic_id, 'openid' => $openid])->first();
    if (empty($topicpraise)) {
      // $praise = new Topicpraise;
      // $praise->praise_status = 0;
      // $praise->openid = $openid;
      // $praise->topic_id = $topic_id;
      // $praise->save();
      return false;
    } else {
      $topicpraise->delete();
      return true;
    }
  }
}
