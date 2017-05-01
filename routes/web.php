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

$app->get('/', function () use ($app) {
    return config('jwt');
});

$app->group(['prefix' => 'api/wx','namespace' => 'Miniapp'], function($app)
{
    /*
     * 微信小程序登录，用户信息验证
     */
    $app->post('login','WxuserController@login');
    $app->post('getuserinfo','WxuserController@getuserinfo');
    $app->post('getopenid','WxuserController@getopenid');

    /*
     * 用户信息填写
     */
    $app->post('info','InfoController@create');
    $app->put('info/{id}','InfoController@update');
    $app->delete('info/{id}','InfoController@delete');
    $app->get('info','InfoController@index');

    /*
     * 匹配查询
     */
    $app->get('evaluation/classify','EvaluationController@classify');
    $app->get('evaluation/match/girl','EvaluationController@matchGirl');
    $app->get('evaluation/match/boy','EvaluationController@matchBoy');
    $app->get('evaluation/match','EvaluationController@match');

});
