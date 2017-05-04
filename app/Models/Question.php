<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Term;

class Question extends Model
{
    protected $fillable = [
      'name',
      'sex',
      'questions'
    ];
    public $timestamps = false;

    public static function dataMigrate() {
      $term = Term::where(['id'=>1])->first();
      $infos = self::where(['term'=>$term->term])->get([
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
        'is_share',
        'question_score_json'
      ])->toArray();
      return $infos;
    }
}
