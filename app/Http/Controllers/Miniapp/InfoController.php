<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Info;
use App\Models\Infoterm;
use App\Models\Question;
use App\Models\Questionterm;
use App\Models\Session;
use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::all();
        return response()->json($infos);
    }

    public function create(Request $request)
    {
        $openid = Session::getOpenid($request->input('session_key'));
        $term = Term::where(['id'=>1])->first();
        Infoterm::where(['openid'=>$openid])->delete();

        Info::where(['openid'=>$openid, 'term'=>$term->term])->delete();

        $info = Info::create($request->all());
        $infoterm = Infoterm::create($request->all());  // 储存单期的用户信息

        $infoterm->openid = $info->openid = $openid;
        $infoterm->term = $info->term = Term::getTerm();
        $info->save();
        $infoterm->save();

        Questionterm::where(['openid'=>$openid])->delete();

        $question = new Question;
        $questionterm = new Questionterm; // 储存单期的用户问卷值
        $questions_data = $request->questions;

        $getBigFiveSum = getBigFiveSum($questions_data);  // 获取big five的5个计算值，函数放入了 helpers.php

        $questionterm->term = $question->term = $info->term;
        $questionterm->openid = $question->openid = $info->openid;
        $questionterm->city = $question->city = $info->province;
        $questionterm->name = $question->name = $request->input('name');
        $questionterm->sex = $question->sex = $request->input('sex');
        $questionterm->extraversion = $question->extraversion = $getBigFiveSum['extraversion'];
        $questionterm->agreeableness = $question->agreeableness = $getBigFiveSum['agreeableness'];
        $questionterm->conscientiousness = $question->conscientiousness = $getBigFiveSum['conscientiousness'];
        $questionterm->neuroticism = $question->neuroticism = $getBigFiveSum['neuroticism'];
        $questionterm->openness = $question->openness = $getBigFiveSum['openness'];
        $questionterm->question_score_json = $question->question_score_json = json_encode($questions_data);

        $question->save();
        $questionterm->save();

        $res = returnCode(true,'成功','success');
        return response()->json($res);
    }

    /*
     *  报名成功，修改本次报名信息
     */
    public function show(Request $request)
    {
        $openid = Session::getOpenid($request->input('session_key'));
        $info = Infoterm::where(['openid' =>$openid])->firstOrFail();
        $question = Questionterm::where(['openid' =>$openid])->firstOrFail();
        $question_score = json_decode($question->question_score_json);
        $new_questions = array();
        foreach ($question_score as $value) {
          array_push($new_questions, $value);
        }
        $info->questions = $new_questions;

        $res = returnCode(true,'成功',$info);
        return response()->json($res);
    }

    /*
     *  报名过一次，第二次报名调用上一次的模版信息
     */
    public function againShow(Request $request)
    {
        $openid = Session::getOpenid($request->input('session_key'));
        $info = Info::where(['openid' =>$openid])->orderBy('created_at', 'desc')->first();
        if (!empty($info)) {
          $question = Question::where(['openid' =>$openid])->first();
          $question_score = json_decode($question->question_score_json);
          $new_questions = array();
          foreach ($question_score as $value) {
            array_push($new_questions, $value);
          }
          $info->questions = $new_questions;
          $res = returnCode(true,'获取以前报名信息成功',$info);
        } else {
          $res = returnCode(false,'第一次参加，暂无信息',[]);
        }

        return response()->json($res);
    }

    public function update(Request $request)
    {
        $openid = Session::getOpenid($request->input('session_key'));

        $info = Info::where(['openid'=>$openid])->firstOrFail();
        $infoterm = Infoterm::where(['openid'=>$openid])->firstOrFail();

        $info->update($request->all());
        $infoterm->update($request->all());

        // $infoterm->openid = $info->openid = $openid;
        $infoterm->term = $info->term = Term::getTerm();
        $info->save();
        $infoterm->save();

        $question = Question::where(['openid'=>$openid])->firstOrFail();
        $questionterm = Questionterm::where(['openid'=>$openid])->firstOrFail();
        $questions_data = $request->questions;

        $getBigFiveSum = getBigFiveSum($questions_data);  // 获取big five的5个计算值，函数放入了 helpers.php

        $questionterm->term = $question->term = $info->term;
        $questionterm->openid = $question->openid = $info->openid;
        $questionterm->city = $question->city = $info->province;
        $questionterm->name = $question->name = $request->input('name');
        $questionterm->sex = $question->sex = $request->input('sex');
        $questionterm->extraversion = $question->extraversion = $getBigFiveSum['extraversion'];
        $questionterm->agreeableness = $question->agreeableness = $getBigFiveSum['agreeableness'];
        $questionterm->conscientiousness = $question->conscientiousness = $getBigFiveSum['conscientiousness'];
        $questionterm->neuroticism = $question->neuroticism = $getBigFiveSum['neuroticism'];
        $questionterm->openness = $question->openness = $getBigFiveSum['openness'];
        $questionterm->question_score_json = $question->question_score_json = json_encode($questions_data);

        $question->save();
        $questionterm->save();

        $res = returnCode(true,'成功','success');
        return response()->json($res);
    }

    public function share(Request $request)
    {
        $openid = Session::getOpenid($request->input('session_key'));

        $question = Question::where(['openid'=>$openid])->firstOrFail();
        $questionterm = Questionterm::where(['openid'=>$openid])->firstOrFail();

        $question->is_share = 1;
        $questionterm->is_share = 1;
        $question->save();
        $questionterm->save();

        $res = returnCode(true,'成功','success');
        return response()->json($res);
    }
}
