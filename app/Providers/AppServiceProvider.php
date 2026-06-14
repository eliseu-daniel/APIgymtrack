<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            $user = $request->user();
            $key = $user ? 'api:' . $user->id : 'api:' . $request->ip();

            return Limit::perMinute(120)->by($key);
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(10)->by('auth:' . $request->ip());
        });
    }
}
