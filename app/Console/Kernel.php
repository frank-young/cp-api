<?php

namespace App\Console;

use App\Models\Topic;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      $schedule->call(function () {
        $topic = new Topic;
        $topic->openid = '382193721das';
        $topic->title = '这是自动任务';
        $topic->description = '这是自动任务';
        $topic->body = '这是自动任务';
        $topic->save();
      })->everyMinute();
    }
}
