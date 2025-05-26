<?php

namespace App\Filament\Widgets;

use App\Models\CostoFijo;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class ProximosPagosWidget extends BaseWidget
{
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';
    
    public function getHeading(): string
    {
        return 'Próximos Pagos Fijos';
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                CostoFijo::query()
                    ->where('usu_idusu', Auth::id())
                    ->where('estado', 'Activo')
                    ->whereDate('costofijo_proximo_pago', '>=', Carbon::now())
                    ->orderBy('costofijo_proximo_pago')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('costofijo_proximo_pago')
                    ->label('Fecha Próximo Pago')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('costofijo_descripcion')
                    ->label('Descripción')
                    ->limit(30),
                TextColumn::make('costofijo_frecuencia')
                    ->label('Frecuencia')
                    ->badge(),
                TextColumn::make('contrapartida.contpuc_nombre')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('costofijo_monto')
                    ->label('Monto')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('dias_restantes')
                    ->label('Días Restantes')
                    ->state(function (CostoFijo $record): int {
                        $today = Carbon::now();
                        $nextPayment = Carbon::parse($record->costofijo_proximo_pago);
                        return $today->diffInDays($nextPayment);
                    })
                    ->badge()
                    ->color(function (int $state): string {
                        if ($state <= 3) return 'danger';
                        if ($state <= 7) return 'warning';
                        return 'success';
                    }),
            ])
            ->actions([])
            ->paginated(false)
            ->defaultSort('costofijo_proximo_pago', 'asc');
    }
}
