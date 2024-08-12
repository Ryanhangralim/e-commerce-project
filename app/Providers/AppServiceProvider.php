<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        // Paginator
        Paginator::useBootstrapFive();
        
        // Check role in blade templates
        Blade::if('role', function(...$roles){
            return Auth::check() && in_array(Auth::user()->role->title, $roles);
        });
    }
}
