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

        $info = Info::create($request->all());
        $infoterm = Infoterm::create($request->all());  // 储存单期的用户信息

        $infoterm->openid = $info->openid = $openid;
        $infoterm->term = $info->term = Term::getTerm();
        $info->save();
        $infoterm->save();

        $question = new Question;
        $questionterm = new Questionterm; // 储存单期的用户问卷值
        $questions_data = $request->questions;

        $getBigFiveSum = getBigFiveSum($questions_data);  // 获取big five的5个计算值，函数放入了 helpers.php

        $questionterm->term = $question->term = $info->term;
        $questionterm->openid = $question->openid = $info->openid;
        $questionterm->city = $question->city = $info->city;
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

    public function show(Request $request)
    {
        $openid = Session::getOpenid($request->input('session_key'));

        $res = returnCode(true,'成功','success');
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {
        $info = Info::find($id);
        $info->name = $request->input('name');
        $info->age = $request->input('age');
        $info->info = $request->input('info');
        $info->save();

        return response()->json($info);
    }

    public function delete($id)
    {
        $info = Info::find($id);
        $info->delete();

        return response()->json('删除成功');
    }
}
