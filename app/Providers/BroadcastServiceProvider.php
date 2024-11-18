<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the broadcasting routes, allowing the frontend to listen to channels
        Broadcast::routes();

        // Load the channel definitions from the routes/channels.php file
        require base_path('routes/channels.php');
    }
}
