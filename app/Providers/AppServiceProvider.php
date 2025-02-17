<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        
        Gate::define('create-project', function ($user) {
            return $user->roles->contains('name', 'admin'); // L'admin peut créer des projets
        });

        Gate::define('join-project', function ($user) {
            return $user->roles->contains('name', 'member'); // Le membre peut rejoindre un projet
        });
    }
}
