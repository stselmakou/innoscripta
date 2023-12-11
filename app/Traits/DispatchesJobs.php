<?php

namespace App\Traits;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;

trait DispatchesJobs
{
    protected function run($job)
    {
        $dispatcher = app(Dispatcher::class);
        if ($job instanceof ShouldQueue) {
            return $dispatcher->dispatchSync($job);
        } else {
            return $dispatcher->dispatchSync($job);
        }
    }
}
