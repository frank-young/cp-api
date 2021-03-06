<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['namespace' => 'App\Http\Controllers\Miniapp'], function ($api) {
    /*
     * 微信小程序登录，用户信息验证
     */
    $api->post('login','WxuserController@login');
    $api->post('getuserinfo','WxuserController@getuserinfo');
    $api->post('getopenid','WxuserController@getopenid');
    /*
     * 用户信息填写
     */
    $api->post('info','InfoController@create');
    $api->put('info/update','InfoController@update');
    $api->post('info/show','InfoController@show');
    $api->post('info/show/again','InfoController@againShow');
    $api->post('info/share','InfoController@share');
    /*
     * 匹配算法，需要加上超级权限
     */
    $api->get('evaluation/classify','EvaluationController@classify');
    $api->get('evaluation/match/move','EvaluationController@matchMove');
    $api->get('evaluation/match/city','EvaluationController@matchCity');
    $api->get('evaluation/match','EvaluationController@match');
    $api->get('evaluation/update','EvaluationController@updateNum');
    /*
     * 用户匹配查询
     */
    $api->post('match','MatchController@index');
    $api->post('match/attendance','MatchController@attendance');
    $api->post('match/attendance/status','MatchController@attendanceStatus');
    /*
     * 匹配管理
     */
    $api->post('manager/term/start','ManagerController@termStart');
    $api->post('manager/term/stop','ManagerController@termStop');
    $api->post('manager/term/info','ManagerController@termInfo');
    $api->post('manager/term/date/info','ManagerController@termDateInfo');
    $api->post('term/status','ManagerController@termStatus');
    /*
     * 任务管理
     */
    $api->post('taskmanager/create','TaskmanagerController@create');
    $api->post('taskmanager/publish','TaskmanagerController@publish');
    $api->post('taskmanager/index','TaskmanagerController@index');
    $api->post('taskmanager/show','TaskmanagerController@show');
    $api->post('taskmanager/update','TaskmanagerController@update');
    /*
     * 管理员，房主添加，超级管理员权限
     */
    $api->post('admin/create','AdminController@create');
    $api->post('admin/role','AdminController@role');
    /*
     * 用户任务获取，以及用户完成任务
     */
    $api->post('task/qiniu/token','TaskController@qiniuToken');
    $api->post('task/list','TaskController@list');
    $api->post('task/show','TaskController@show');

    $api->post('taskahead/create','TaskaheadController@create');
    $api->post('taskahead/show','TaskaheadController@show');
    /*
     * 话题部分
     */
    $api->post('topic/create','TopicController@create');
    $api->post('topic','TopicController@index');
    $api->post('topic/show','TopicController@show');
    /*
     * 话题评论部分
     */
    $api->post('comment/create','CommentController@create');
    $api->post('comment/index','CommentController@index');
    $api->post('comment/show','CommentController@show');

    /*
     * 话题点赞部分
     */
    $api->post('topicpraise/status','TopicpraiseController@status');
    $api->post('topicpraise/agree','TopicpraiseController@agree');
    $api->post('topicpraise/cancel','TopicpraiseController@cancel');

    /*
     * 回复评论部分
     */
    $api->post('replaycomment/create','ReplaycommentController@create');
    $api->post('replaycomment/index','ReplaycommentController@index');

    /*
     * 评论点赞部分
     */
    $api->post('commentpraise/status','CommentpraiseController@status');
    $api->post('commentpraise/agree','CommentpraiseController@agree');
    $api->post('commentpraise/cancel','CommentpraiseController@cancel');

    /*
     * 申请房主
     */
    $api->post('applyroom/create','ApplyroomController@create');
    $api->post('applyroom/index','ApplyroomController@index');
    $api->post('applyroom/agree','ApplyroomController@agree');
    $api->post('applyroom/notagree','ApplyroomController@notAgree');
    $api->post('applyroom/status','ApplyroomController@status');

    /*
     * 添加房间
     */
    $api->post('room/create','RoomController@create');
    $api->post('room/index','RoomController@index');
    $api->post('room/show','RoomController@show');
    $api->post('room/update','RoomController@update');
    $api->post('room/num','RoomController@num');

    /*
     * 微信服务端响应
     */
    $api->post('wechat/response','WechatController@response');

});
