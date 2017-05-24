<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
      'topic_id',
      'content',
      'praise_num',
      'replay_num'
    ];
}
