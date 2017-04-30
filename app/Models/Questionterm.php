<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionterm extends Model
{
    protected $fillable = [
      'name',
      'sex',
      'questions'
    ];
     public $timestamps = false;
}
