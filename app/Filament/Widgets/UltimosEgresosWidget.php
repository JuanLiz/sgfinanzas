<?php

namespace App\Filament\Widgets;

use App\Models\Egreso;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class UltimosEgresosWidget extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';
    
    public function getHeading(): string
    {
        return 'Últimos Egresos';
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Egreso::query()
                    ->where('usu_idusu', Auth::id())
                    ->where('estado', 'Activo')
                    ->latest('egres_fecha')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('egres_fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('egres_descripcion')
                    ->label('Descripción')
                    ->limit(30),
                TextColumn::make('egres_tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Fijo' => 'primary',
                        'Variable' => 'warning',
                        'Urgente' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('contrapartida.contpuc_nombre')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('egres_monto')
                    ->label('Monto')
                    ->money('USD')
                    ->sortable(),
            ])
            ->actions([])
            ->paginated(false)
            ->defaultSort('egres_fecha', 'desc');
    }
}
