<?php

namespace App\Filament\Widgets;

use App\Models\Inversion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InversionesTotalesWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    public function getHeading(): string
    {
        return 'Inversiones';
    }
    
    protected function getStats(): array
    {
        $userId = Auth::id();
        
        // Calcular inversiones totales
        $inversionesTotales = Inversion::where('usu_idusu', $userId)
            ->where('estado', 'Activo')
            ->sum('inversion_monto');
            
        // Rendimiento esperado total (calculado como porcentaje del monto invertido)
        $inversiones = Inversion::where('usu_idusu', $userId)
            ->where('estado', 'Activo')
            ->select('inversion_monto', 'inversion_rendimiento_esperado')
            ->get();
            
        $rendimientoEsperado = 0;
        foreach ($inversiones as $inversion) {
            $rendimientoEsperado += ($inversion->inversion_monto * $inversion->inversion_rendimiento_esperado / 100);
        }
            
        // Obtener tipos de inversiones y sus montos
        $tipoInversiones = Inversion::where('usu_idusu', $userId)
            ->where('estado', 'Activo')
            ->select('inversion_tipo', DB::raw('SUM(inversion_monto) as total'))
            ->groupBy('inversion_tipo')
            ->pluck('total', 'inversion_tipo')
            ->toArray();
            
        // Encontrar el tipo de inversión con mayor monto
        $tipoMayor = !empty($tipoInversiones) ? array_search(max($tipoInversiones), $tipoInversiones) : 'N/A';
            
        return [
            Stat::make('Total Invertido', number_format($inversionesTotales, 2, ',', '.') . ' $')
                ->description('Monto total en inversiones')
                ->descriptionIcon('heroicon-m-presentation-chart-line')
                ->color('primary'),
                
            Stat::make('Rendimiento esperado', number_format($rendimientoEsperado, 2, ',', '.') . ' $')
                ->description('Rendimiento total esperado')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Principal Inversión', $tipoMayor)
                ->description('Tipo de inversión con mayor monto')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
