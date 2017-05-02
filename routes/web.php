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
    $api->put('info/{id}','InfoController@update');
    $api->delete('info/{id}','InfoController@delete');
    $api->get('info','InfoController@index');

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

    /*
     * 匹配管理
     */
     $api->get('manager/term/start','ManagerController@termStart');
     $api->get('manager/term/stop','ManagerController@termStop');

     /*
      * 微信服务端响应
      */
      $api->post('wechat/response','WechatController@response');

});
