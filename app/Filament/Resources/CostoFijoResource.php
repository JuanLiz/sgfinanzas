<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CostoFijoResource\Pages;
use App\Models\ContrapartidaPUC;
use App\Models\CostoFijo;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CostoFijoResource extends Resource
{
    protected static ?string $model = CostoFijo::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $modelLabel = 'Costo Fijo';
    protected static ?string $pluralModelLabel = 'Costos Fijos';
    protected static ?string $navigationGroup = 'Finanzas';
    protected static ?int $navigationSort = 40;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('costofijo_monto')
                    ->label('Monto')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0.01)
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Select::make('costofijo_frecuencia')
                    ->label('Frecuencia')
                    ->options([
                        'Mensual' => 'Mensual',
                        'Bimestral' => 'Bimestral',
                        'Trimestral' => 'Trimestral',
                        'Semestral' => 'Semestral',
                        'Anual' => 'Anual',
                    ])
                    ->required()
                    ->columnSpan(['lg' => 1]),
                    
                Forms\Components\TextInput::make('costofijo_dia_mes')
                    ->label('Día del mes para pago')
                    ->integer()
                    ->minValue(1)
                    ->maxValue(31)
                    ->required()
                    ->columnSpan(['lg' => 1]),
                    
                Forms\Components\DatePicker::make('costofijo_proximo_pago')
                    ->label('Próximo pago')
                    ->required()
                    ->default(now())
                    ->columnSpan(['lg' => 1]),
                    
                Forms\Components\Select::make('contpuc_idcontpuc')
                    ->label('Categoría')
                    ->options(function() {
                        return ContrapartidaPUC::where('estado', 'Activo')
                            ->where('contpuc_tipo', 'Egreso')
                            ->get()
                            ->mapWithKeys(function ($contrapartida) {
                                return [$contrapartida->idcontpuc => "{$contrapartida->contpuc_codigo} - {$contrapartida->contpuc_descripcion}"];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Textarea::make('costofijo_descripcion')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Select::make('usu_idusu')
                    ->label('Usuario')
                    ->options(function() {
                        return User::where('estado', 'Activo')
                            ->get()
                            ->mapWithKeys(function ($user) {
                                return [$user->idusu => $user->usua_nombre];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->default(auth()->id())
                    ->visible(fn () => auth()->user()->isAdmin())
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Inactivo' => 'Inactivo',
                    ])
                    ->default('Activo')
                    ->required()
                    ->visible(fn (string $operation): bool => $operation === 'edit')
                    ->columnSpan(['lg' => 1]),

                Forms\Components\DateTimePicker::make('fecha_registro')
                    ->label('Fecha de Registro')
                    ->disabled()
                    ->visibleOn('edit')
                    ->columnSpan(['lg' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // Si no es administrador, filtrar solo por el usuario autenticado
                if (!auth()->user()->isAdmin()) {
                    $query->where('usu_idusu', auth()->id());
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('idcostofijo')
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('costofijo_monto')
                    ->label('Monto')
                    ->money('COP')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('costofijo_frecuencia')
                    ->label('Frecuencia')
                    ->badge()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('costofijo_proximo_pago')
                    ->label('Próximo pago')
                    ->date()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('contrapartida.contpuc_descripcion')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('usuario.usua_nombre')
                    ->label('Usuario')
                    ->visible(fn () => auth()->user()->isAdmin())
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('costofijo_descripcion')
                    ->label('Descripción')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: false),
                    
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn ($record): string => 
                        $record->trashed()
                            ? 'danger'
                            : (($record->estado === 'Activo') ? 'success' : 'warning')
                    )
                    ->formatStateUsing(fn ($record) => $record->trashed() ? 'Eliminado' : $record->estado),
                    
                Tables\Columns\TextColumn::make('fecha_registro')
                    ->label('Fecha de Registro')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('costofijo_frecuencia')
                    ->options([
                        'Mensual' => 'Mensual',
                        'Bimestral' => 'Bimestral',
                        'Trimestral' => 'Trimestral',
                        'Semestral' => 'Semestral',
                        'Anual' => 'Anual',
                    ])
                    ->label('Frecuencia')
                    ->indicator('Frecuencia'),
                    
                SelectFilter::make('contpuc_idcontpuc')
                    ->relationship('contrapartida', 'contpuc_descripcion')
                    ->label('Categoría')
                    ->searchable()
                    ->preload()
                    ->indicator('Categoría'),
                    
                SelectFilter::make('usu_idusu')
                    ->relationship('usuario', 'usua_nombre')
                    ->label('Usuario')
                    ->searchable()
                    ->preload()
                    ->visible(fn () => auth()->user()->isAdmin())
                    ->indicator('Usuario'),
                    
                Filter::make('costofijo_proximo_pago')
                    ->form([
                        Forms\Components\DatePicker::make('desde')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('hasta')
                            ->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['desde'],
                                fn (Builder $query, $date): Builder => $query->whereDate('costofijo_proximo_pago', '>=', $date),
                            )
                            ->when(
                                $data['hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('costofijo_proximo_pago', '<=', $date),
                            );
                    })
                    ->indicator(fn (array $data): ?string => $data['desde'] || $data['hasta'] ? 'Fechas filtradas' : null),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCostosFijos::route('/'),
            'create' => Pages\CreateCostoFijo::route('/create'),
            'edit' => Pages\EditCostoFijo::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
