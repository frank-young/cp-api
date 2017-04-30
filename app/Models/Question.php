<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
      'name',
      'sex',
      'questions'
    ];
     public $timestamps = false;
}
