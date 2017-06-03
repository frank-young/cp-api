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
      'content',
      'is_agree'
    ];
    // 查询话题所对应的用户
    public function user() {
      return $this->belongsTo('App\Models\Wxuser', 'openid', 'openid');
    }
}
