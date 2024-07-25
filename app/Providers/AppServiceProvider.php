<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\Twilio\Twilio;
use NotificationChannels\Twilio\TwilioChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
