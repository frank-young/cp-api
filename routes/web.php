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

$app->group(['prefix' => 'api/v1.0.0'], function($app)
{
    /*
     * 微信登录
     */
    $app->get('login','Miniapp\WxuserController@login');

    /*
     * 用户信息填写
     */
    $app->post('info','InfoController@create');
    $app->put('info/{id}','InfoController@update');
    $app->delete('info/{id}','InfoController@delete');
    $app->get('info','InfoController@index');

});
