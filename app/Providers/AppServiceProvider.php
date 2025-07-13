<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model; 

use Filament\Facades\Filament;


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
        //
        Model::unguard();


    Filament::serving(function () {
        Filament::registerRenderHook(
            'scripts.end',
            fn (): string => view('filament.scripts.focus-next')->render(),
        );
    });
}

}
