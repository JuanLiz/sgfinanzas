<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InversionResource\Pages;
use App\Models\ContrapartidaPUC;
use App\Models\Inversion;
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
use Illuminate\Support\Carbon;

class InversionResource extends Resource
{
    protected static ?string $model = Inversion::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $modelLabel = 'Inversión';
    protected static ?string $pluralModelLabel = 'Inversiones';
    protected static ?string $navigationGroup = 'Finanzas';
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('inversion_monto')
                    ->label('Monto')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0.01)
                    ->columnSpan(['lg' => 1]),

                Forms\Components\DatePicker::make('inversion_fecha')
                    ->label('Fecha')
                    ->required()
                    ->default(now())
                    ->columnSpan(['lg' => 1]),
                    
                Forms\Components\Select::make('inversion_tipo')
                    ->label('Tipo de Inversión')
                    ->options([
                        'CDT' => 'CDT',
                        'Acciones' => 'Acciones',
                        'Fondos' => 'Fondos de Inversión',
                        'Finca Raiz' => 'Finca Raíz',
                        'Criptomonedas' => 'Criptomonedas',
                        'Otros' => 'Otros',
                    ])
                    ->required()
                    ->columnSpan(['lg' => 1]),
                    
                Forms\Components\TextInput::make('inversion_rendimiento_esperado')
                    ->label('Rendimiento Esperado (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->suffix('%')
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

                Forms\Components\Textarea::make('inversion_descripcion')
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
            ->columns([
                Tables\Columns\TextColumn::make('idinversion')
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('inversion_monto')
                    ->label('Monto')
                    ->money('COP')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('inversion_fecha')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('inversion_tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CDT' => 'warning',
                        'Acciones' => 'danger',
                        'Fondos' => 'info',
                        'Finca Raiz' => 'success',
                        'Criptomonedas' => 'purple',
                        default => 'gray',
                    })
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('inversion_rendimiento_esperado')
                    ->label('Rendimiento')
                    ->formatStateUsing(fn ($state) => number_format($state, 2) . '%')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('contrapartida.contpuc_descripcion')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('usuario.usua_nombre')
                    ->label('Usuario')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('inversion_descripcion')
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
                SelectFilter::make('inversion_tipo')
                    ->options([
                        'CDT' => 'CDT',
                        'Acciones' => 'Acciones',
                        'Fondos' => 'Fondos de Inversión',
                        'Finca Raiz' => 'Finca Raíz',
                        'Criptomonedas' => 'Criptomonedas',
                        'Otros' => 'Otros',
                    ])
                    ->label('Tipo')
                    ->indicator('Tipo'),
                    
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
                    ->indicator('Usuario'),
                    
                Filter::make('inversion_fecha')
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
                                fn (Builder $query, $date): Builder => $query->whereDate('inversion_fecha', '>=', $date),
                            )
                            ->when(
                                $data['hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('inversion_fecha', '<=', $date),
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
            'index' => Pages\ListInversiones::route('/'),
            'create' => Pages\CreateInversion::route('/create'),
            'edit' => Pages\EditInversion::route('/{record}/edit'),
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
