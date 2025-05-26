<?php

namespace App\Filament\Widgets;

use App\Models\Egreso;
use App\Models\Ingreso;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IngresosEgresosGraficoWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $pollingInterval = null;
    
    public function getHeading(): string
    {
        return 'Ingresos vs Egresos';
    }
    
    protected function getData(): array
    {
        $userId = Auth::id();
        return $this->getDailyData($userId);
    }
    

    public function getColumnSpan(): int | string | array
    {
        return 2;
    }
    
    protected function getDailyData($userId): array
    {
        $lastThirtyDays = [];
        
        // Generar los últimos 30 días para el eje X, mostrando todos los días
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            
            $lastThirtyDays[$dateKey] = [
                'label' => $date->format('d M'),
                'ingresos' => 0,
                'egresos' => 0
            ];
        }
        
        // Consultar ingresos de los últimos 30 días
        $ingresos = Ingreso::where('usu_idusu', $userId)
            ->where('estado', 'Activo')
            ->where('ingre_fecha', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('to_char(ingre_fecha, \'YYYY-MM-DD\') as dia'), DB::raw('SUM(ingre_monto) as total'))
            ->groupBy('dia')
            ->get();
            
        foreach ($ingresos as $ingreso) {
            if (isset($lastThirtyDays[$ingreso->dia])) {
                $lastThirtyDays[$ingreso->dia]['ingresos'] = round($ingreso->total, 2);
            }
        }
        
        // Consultar egresos de los últimos 30 días
        $egresos = Egreso::where('usu_idusu', $userId)
            ->where('estado', 'Activo')
            ->where('egres_fecha', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('to_char(egres_fecha, \'YYYY-MM-DD\') as dia'), DB::raw('SUM(egres_monto) as total'))
            ->groupBy('dia')
            ->get();
            
        foreach ($egresos as $egreso) {
            if (isset($lastThirtyDays[$egreso->dia])) {
                $lastThirtyDays[$egreso->dia]['egresos'] = round($egreso->total, 2);
            }
        }
        
        // Mostrar todos los datos de los 30 días con líneas suaves sin puntos marcadores
        return [
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => array_column($lastThirtyDays, 'ingresos'),
                    'backgroundColor' => 'rgba(20, 184, 166, 0.2)', // Color Teal con transparencia
                    'borderColor' => 'rgb(20, 184, 166)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4, // Hace que las líneas sean más suaves
                    'pointStyle' => false, // Sin puntos marcadores
                    'pointRadius' => 0, // Sin radio para los puntos
                ],
                [
                    'label' => 'Egresos',
                    'data' => array_column($lastThirtyDays, 'egresos'),
                    'backgroundColor' => 'rgba(234, 84, 85, 0.2)', // Rojo con transparencia
                    'borderColor' => 'rgb(234, 84, 85)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                    'pointStyle' => false, // Sin puntos marcadores
                    'pointRadius' => 0, // Sin radio para los puntos
                ],
            ],
            'labels' => array_column($lastThirtyDays, 'label'),
        ];
    }
    
    protected function getType(): string
    {
        // Usar líneas para ambos tipos de datos para mejor comparación
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                    'labels' => [
                        'padding' => 10,
                        'boxWidth' => 10,
                        'font' => [
                            'size' => 11 // Fuente más pequeña para la leyenda
                        ]
                    ]
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => '(value) => value + " $"',
                        'maxTicksLimit' => 5, // Reducido a 5 divisiones
                        'font' => [
                            'size' => 10 // Fuente más pequeña
                        ]
                    ],
                    'grid' => [
                        'drawBorder' => false,
                        'color' => 'rgba(0,0,0,0.05)'
                    ]
                ],
                'x' => [
                    'ticks' => [
                        'maxRotation' => 45, // Mayor rotación para acomodar más etiquetas
                        'minRotation' => 0,
                        'font' => [
                            'size' => 9 // Fuente más pequeña para acomodar todas las etiquetas
                        ],
                        'autoSkip' => true, // Permite saltarse etiquetas para mejor legibilidad
                        'autoSkipPadding' => 10, // Espacio entre etiquetas
                        'maxTicksLimit' => 10 // Límite automático de etiquetas visible
                    ],
                    'grid' => [
                        'display' => false, // Sin líneas de cuadrícula verticales
                        'drawBorder' => false
                    ]
                    ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => true,
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'layout' => [
                'padding' => [
                    'top' => 5,
                    'right' => 10,
                    'bottom' => 5,
                    'left' => 10
                ]
            ],
        ];
    }
}
