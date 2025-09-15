<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Livewire\Volt\Volt;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(UrlGenerator $url): void
    {
        // Volt::mount([
        //     resource_path('views/livewire'),
        // ]);
        if (env('APP_ENV') === 'production') {
            $url->forceScheme('https');
        }
    }
}
