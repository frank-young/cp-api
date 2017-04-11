<?php

namespace Cp\JWT\Provider;


use Illuminate\Support\ServiceProvider;

class LumenServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //从应用根目录的config文件夹中加载用户的jwt配置文件
        $this->app->configure('jwt');

        //获取扩展包配置文件的真实路径
        $path = realpath(__DIR__ . '/../../config/jwt.php');

        //将扩展包的配置文件merge进用户的配置文件中
        $this->mergeConfigFrom($path, 'jwt');
    }
}
