<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ApiException;

class Admin extends Model
{
     public $timestamps = false;

     /*
      * 添加管理员
      */
     public static function addOne(Array $data, $openid)
     {
        $admin = self::where(['openid'=>$openid])->first();
        if (!empty($admin)) {
          throw new ApiException('记录已经存在');
        } else {
          $res = DB::table('admins')->insert($data);
        }
        return $res;
     }
     /*
      * 添加权限
      */
     public static function setRole($type, $openid)
     {
        $admin = self::where(['openid'=>$openid])->first();
        if (empty($admin)) {
          throw new ApiException('管理员不存在');
        } else {
          if ($type == 'ADMIN') {
            $admin->role = 50;
          } else if ($type == 'HOUSE_OWNER') {
            $admin->role = 10;
          }
          $admin->save();
        }
     }

     /*
      * 获取权限
      */
     public static function getRole($openid)
     {
        $admin = self::where(['openid'=>$openid])->first();
        if (empty($admin)) {
          throw new ApiException('管理员不存在');
        } else {
          if ($admin->role == 50) {
            $res = 'ADMIN';
          } else if ($admin->role == 10) {
            $res == 'HOUSE_OWNER';
          } else {
            $res == 'OTHER';
          }
        }
        return $res;
     }

}
