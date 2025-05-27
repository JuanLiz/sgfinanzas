<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\URL;


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
        URL::forceScheme('https');
        // Configuración de los grupos de navegación en Filament
        Filament::serving(function () {
            // Configurar los grupos de navegación en el orden deseado
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Transacciones'),
                NavigationGroup::make()
                    ->label('Finanzas'),
                NavigationGroup::make()
                    ->label('Contabilidad'),
                NavigationGroup::make()
                    ->label('Administración de acceso'),
                NavigationGroup::make()
                    ->label('Configuración general'),
            ]);
        });
    }
}
