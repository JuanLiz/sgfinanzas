<?php

namespace App\Filament\Pages;

use App\Models\Egreso;
use App\Models\Ingreso;
use App\Models\Inversion;
use Filament\Actions\Action;
use Filament\Pages\Dashboard;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;    

class FinancialDashboard extends Dashboard
{
    protected static ?string $navigationLabel = 'Inicio';
    protected static ?string $title = 'Mis finanzas';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\BalanceGeneralWidget::class,
            \App\Filament\Widgets\InversionesTotalesWidget::class,
            \App\Filament\Widgets\IngresosEgresosGraficoWidget::class,
            \App\Filament\Widgets\UltimosIngresoWidget::class,
            \App\Filament\Widgets\UltimosEgresosWidget::class,
            \App\Filament\Widgets\ProximosPagosWidget::class,
        ];
    }


    public function getColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }

    public function mount(): void
    {
    
    }
}
