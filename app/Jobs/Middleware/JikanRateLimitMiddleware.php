<?php

namespace App\Jobs\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class JikanRateLimitMiddleware
{
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        Redis::throttle('jikan-api')
            ->block(0)->allow(3)->every(1)
            ->then(function () use ($job, $next) {
                $next($job);
            }, function () use ($job) {
                $job->release(2);
            });
    }
}
