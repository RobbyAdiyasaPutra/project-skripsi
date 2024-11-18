<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Defining rate limiter for the API routes
        RateLimiter::for('api', function (Request $request) {
            // Limit the API requests to 60 per minute per user (based on user ID or IP)
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Registering the route groups and middlewares
        $this->routes(function () {
            // API Routes
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Web Routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
