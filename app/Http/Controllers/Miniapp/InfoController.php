<?php
namespace App\Http\Controllers\Miniapp;

use App\Models\Info;
use App\Models\Question;
use App\Models\Session;
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
        $session = Session::where(['private_session_key'=>$request->input('session_key')])->first();

        $info = Info::create($request->all());
        $info->openid = $session->openid;
        $info->term = 0;
        $info->save();

        $question = new Question;
        $questions_data = $request->questions;

        $getBigFiveSum = getBigFiveSum($questions_data);  // 函数放入了 helpers.php

        $question->openid = $info->term;
        $question->openid = $info->openid;
        $question->name = $request->input('name');
        $question->sex = $request->input('sex');
        $question->extraversion = $getBigFiveSum['extraversion'];
        $question->agreeableness = $getBigFiveSum['agreeableness'];
        $question->conscientiousness = $getBigFiveSum['conscientiousness'];
        $question->neuroticism = $getBigFiveSum['neuroticism'];
        $question->openness = $getBigFiveSum['openness'];
        $question->question_score_json = json_encode($questions_data);
        $question->save();

        $res = returnCode(true,'成功','success');
        return response()->json($res);
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
