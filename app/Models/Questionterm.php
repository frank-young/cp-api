<?php
namespace App\Models;

use App\Models\Boy;
use App\Models\Girl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Questionterm extends Model
{
    protected $fillable = [
      'name',
      'sex',
      'questions'
    ];
    public $timestamps = false;

    public static function clearData() {
      self::chunk(200, function ($datas) {
        foreach ($datas as $data) {
          self::find($data->id)->delete();
        }
      });
    }

    public static function addData() {
      // self::chunk(200, function ($datas) {
      //   foreach ($datas as $data) {
      //     if ($data->sex == 0) {
      //       Boy::addData($data);
      //     } else {
      //       Girl::addData($data);
      //     }
      //   }
      // });
      foreach (self::where('is_share', 1)->cursor() as $data) {
        if ($data->sex == 0) {
          Boy::addData($data);
        } else {
          Girl::addData($data);
        }
      }
    }

    public static function addAll(Array $data)
    {
        $res = DB::table('questionterms')->insert($data);
        return $res;
    }

    public static function cityMatch($city)
    {
      $infos = self::where(['city'=>$city, 'is_share'=>1])->get([
        'term',
        'openid',
        'name',
        'sex',
        'city',
        'extraversion',
        'agreeableness',
        'conscientiousness',
        'neuroticism',
        'openness'
      ])->toArray();
      return $infos;
    }
}
