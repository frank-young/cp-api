<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taskmanager extends Model
{
     public $timestamps = false;
     protected $fillable = [
      'model',
      'num',
      'title',
      'body',
      'type'
    ];
}
