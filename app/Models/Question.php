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

    public static function dataMigrate() {
      $infos = self::where(['term'=>0])->get([
        'term',
        'openid',
        'name',
        'sex',
        'city',
        'extraversion',
        'agreeableness',
        'conscientiousness',
        'neuroticism',
        'openness',
        'question_score_json'
      ])->toArray();
      return $infos;
    }
}
