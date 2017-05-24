<?php
namespace App\Models;

use App\Models\Wxuser;
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
    public function user() {
      return $this->belongsTo('App\Models\Wxuser', 'openid', 'openid');
    }
}
