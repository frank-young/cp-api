<?php
namespace App\Models;

use App\Models\Wxuser;
// use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
      'title',
      'description',
      'body',
      'favorited',
      'thumbnail_pic',
      'image_path',
      'praise_num',
      'comment_num'
    ];
    // 查询话题所对应的用户
    public function user() {
      return $this->belongsTo('App\Models\Wxuser', 'openid', 'openid');
    }
    // 评论增加评论
    static public function addCommentNum($id) {
      $res = self::where(['id' => $id])->first();
      $res->comment_num = $res->comment_num + 1;
      $res->save();
    }
    // 查询话题所对应的评论
    // public function hasManyComment()
    // {
    //   return $this->hasMany('App\Models\Comment', 'topic_id', 'id');
    // }

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
