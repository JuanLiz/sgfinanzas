<?php

namespace App\Filament\Widgets;

use App\Models\Egreso;
use App\Models\Ingreso;
use App\Models\Inversion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class BalanceGeneralWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    public function getHeading(): string
    {
        return 'Balance General';
    }
    
    protected function getStats(): array
    {
        $userId = Auth::id();
        
        // Calcular ingresos totales
        $ingresosTotales = Ingreso::where('usu_idusu', $userId)
            ->where('estado', 'Activo')
            ->sum('ingre_monto');
            
        // Calcular egresos totales
        $egresosTotales = Egreso::where('usu_idusu', $userId)
            ->where('estado', 'Activo')
            ->sum('egres_monto');
        
        // Calcular balance (ingresos - egresos)
        $balanceTotal = $ingresosTotales - $egresosTotales;
        
        return [
            Stat::make('Ingresos Totales', number_format($ingresosTotales, 2, ',', '.') . ' $')
                ->description('Total de ingresos registrados')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            
            Stat::make('Egresos Totales', number_format($egresosTotales, 2, ',', '.') . ' $')
                ->description('Total de egresos registrados')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
                
            Stat::make('Balance Neto', number_format($balanceTotal, 2, ',', '.') . ' $')
                ->description($balanceTotal >= 0 ? 'Balance positivo' : 'Balance negativo')
                ->descriptionIcon($balanceTotal >= 0 ? 'heroicon-m-banknotes' : 'heroicon-m-exclamation-circle')
                ->color($balanceTotal >= 0 ? 'success' : 'danger'),
        ];
    }
}
