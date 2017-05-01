<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Info;
use App\Models\Question;
use App\Models\Questionterm;
use App\Models\Session;
use App\Models\Boy;
use App\Models\Girl;
use App\Models\Match;
use App\Models\Matchterm;
use App\Models\Infoterm;
use App\Models\Usercache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    public function classify()
    {
        Girl::clearData();
        Boy::clearData();
        Matchterm::clearData(); // 清空本期匹配数据
        Questionterm::addData();

        $res = returnCode(true,'分类成功','success');
        return response()->json($res);
    }
    /*
     * 重新导入本期匹配问题信息数据，此接口主要用于测试，和匹配数据出错的二次匹配
     */
    public function matchMove()
    {
      Questionterm::clearData();  // 清空本期questionterm
      $infos = Question::dataMigrate(); // 数据迁移
      Questionterm::addAll($infos); // 添加到questionterm
      $res = returnCode(true,'成功','success');
      return response()->json($res);
    }

    /*
     * 按城市匹配
     */
    public function matchCity()
    {
      $start_time=microtime(true);  // 计时器
      $index = 0; // 计数器

      //同城市匹配
      Matchterm::clearData(); // 清空匹配数据
      Usercache::clearData(); // 清空缓存数据，这里将每次从questionterm（每期问题答案）中挑出单次城市的数据
      $cities = Infoterm::getCity();  // 查询本次报名的城市信息
      foreach ($cities as $city) {
        $infos = Questionterm::cityMatch($city);  // 查询出单个城市的数据
        Usercache::addAll($infos);  // 存入缓存表
        Girl::clearData();  // 清空女孩缓存表
        Boy::clearData(); // 清空男孩缓存表
        $users = Usercache::addData();  // 这里是向男孩和女孩缓存表添加数据，因为需要判断，所以加载了Usercache中
        while (Girl::all()->count() != 0 && Boy::all()->count() != 0) { // 如果有一方匹配完就不执行
          Girl::matchingAlgorithm();  // 女孩匹配算法
          Boy::matchingAlgorithm(); // 男孩匹配算法

          $girls = Girl::cursor();  // 查询所有女孩数据
          foreach ($girls as $girl) {
            $boys = Boy::cursor();  // 查询所有男孩数据
            foreach ($boys as $boy) {
              $index++;
              if ($girl->match_openid == $boy->openid && $boy->match_openid == $girl->openid) { // 男孩看中女孩，并且女孩看中男孩，就存入数据
                Match::addData($girl);  // 存入总匹配数据
                Matchterm::addData($girl); // 存入单期匹配数据，用户查询也是这个表

                Match::addData($boy); // 这里第二次是存入了男孩的数据，方便查询
                Matchterm::addData($boy);

                Girl::where(['openid' => $girl->openid])->delete(); // 删除匹配完的数据
                Boy::where(['openid' => $boy->openid])->delete();
                Questionterm::where(['openid'=>$girl->openid])->delete(); // 删除用过的用户匹配信息数据
                Questionterm::where(['openid'=>$boy->openid])->delete();
              }
            }
          }
        }
        Usercache::clearData(); // 清空本次缓存数据，也就是这个城市的用户匹配数据
      }

      // 匹配剩下用户，以上匹配会存在剩余数据，及不是同一个城市，那么进行再次的匹配
      Girl::clearData();  // 同样先清空男孩、女孩的缓存数据表
      Boy::clearData();
      Questionterm::addData();  // 向男女孩缓存表添加数据，这里直接用questionterm，是因为上面已经进行了匹配删除，剩下的都是未匹配的

      while (Girl::all()->count() != 0 && Boy::all()->count() != 0) { // 逻辑和上面一样
        Girl::matchingAlgorithm();
        Boy::matchingAlgorithm();

        $girls = Girl::cursor();
        foreach ($girls as $girl) {
          $boys = Boy::cursor();
          foreach ($boys as $boy) {
            $index++;
            if ($girl->match_openid == $boy->openid && $boy->match_openid == $girl->openid) {
              Match::addData($girl);
              Matchterm::addData($girl);

              Match::addData($boy);
              Matchterm::addData($boy);

              Girl::where(['openid' => $girl->openid])->delete();
              Boy::where(['openid' => $boy->openid])->delete();
              Questionterm::where(['openid'=>$girl->openid])->delete();
              Questionterm::where(['openid'=>$boy->openid])->delete();
            }
          }
        }
      }

      $end_time=microtime(true);   // 计时结束
      $total_time = number_format($end_time - $start_time, 2);

      $res = returnCode(true,'成功', ['time' => '耗时'.$total_time.'秒','per'=>'计算次数'.$index.'次']);
      return response()->json($res);
    }

    /*
     * 剩余二次匹配
     */

    public function match()
    {
      $start_time=microtime(true);

      Girl::clearData();
      Boy::clearData();
      // Matchterm::clearData(); // 清空本期匹配数据
      Questionterm::addData();

      while (Girl::all()->count() != 0 && Boy::all()->count() != 0) {
        Girl::matchingAlgorithm();
        Boy::matchingAlgorithm();

        $girls = Girl::cursor();
        foreach ($girls as $girl) {
          $boys = Boy::cursor();
          foreach ($boys as $boy) {
            if ($girl->match_openid == $boy->openid && $boy->match_openid == $girl->openid) {
              Match::addData($girl);
              Matchterm::addData($girl);

              Match::addData($boy);
              Matchterm::addData($boy);

              Girl::where(['openid' => $girl->openid])->delete();
              Boy::where(['openid' => $boy->openid])->delete();
              Questionterm::where(['openid'=>$girl->openid])->delete();
              Questionterm::where(['openid'=>$boy->openid])->delete();
            }
          }
        }
      }
      $end_time=microtime(true);

      $total_time = number_format($end_time - $start_time, 2);

      $res = returnCode(true,'匹配成功',['time' => $total_time.'秒']);
      return response()->json($res);
    }
}
