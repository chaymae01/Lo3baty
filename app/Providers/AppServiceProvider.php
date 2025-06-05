<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\ReclamationObserver;
use App\Models\Reclamation;

use App\Models\Annonce;
use App\Observers\AnnonceObserver;

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
    Schema::defaultStringLength(191);
     
    Reclamation::observe(ReclamationObserver::class);
    Annonce::observe(AnnonceObserver::class);
}

}