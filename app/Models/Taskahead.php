<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taskahead extends Model
{
     public $timestamps = false;
     protected $fillable = [
       'term',
       'group_id',
       'taskmanager_id',
       'image_path',
       'text',
       'voice',
       'other'
    ];
}
