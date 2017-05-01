<?php
namespace App\Models;

use App\Models\Boy;
use App\Models\Girl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usercache extends Model
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
      self::chunk(200, function ($datas) {
        foreach ($datas as $data) {
          if ($data->sex == 0) {
            Boy::addData($data);
          } else {
            Girl::addData($data);
          }
        }
      });
    }

    public static function addAll(Array $data)
    {
        $res = DB::table('usercaches')->insert($data);
        return $res;
    }
}
