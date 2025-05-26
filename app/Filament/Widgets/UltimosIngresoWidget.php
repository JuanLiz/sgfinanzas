<?php

namespace App\Filament\Widgets;

use App\Models\Ingreso;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class UltimosIngresoWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';
    
    public function getHeading(): string
    {
        return 'Últimos Ingresos';
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ingreso::query()
                    ->where('usu_idusu', Auth::id())
                    ->where('estado', 'Activo')
                    ->latest('ingre_fecha')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('ingre_fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('ingre_descripcion')
                    ->label('Descripción')
                    ->limit(30),
                TextColumn::make('contrapartida.contpuc_nombre')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ingre_monto')
                    ->label('Monto')
                    ->money('USD')
                    ->sortable(),
            ])
            ->actions([])
            ->paginated(false)
            ->defaultSort('ingre_fecha', 'desc');
    }
}
