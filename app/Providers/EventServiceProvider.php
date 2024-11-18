<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * This method is used to bind events and listeners.
     */
    public function boot(): void
    {
        parent::boot();

        // You can place additional event listeners registration here if needed.
        // Example:
        // Event::listen(SomeEvent::class, SomeListener::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        // Set to true to enable automatic event discovery if needed
        return false; // In most cases, this is set to false unless you want to use auto-discovery.
    }
}
