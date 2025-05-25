<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IngresoResource\Pages;
use App\Models\ContrapartidaPUC;
use App\Models\Ingreso;
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

class IngresoResource extends Resource
{
    protected static ?string $model = Ingreso::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static ?string $modelLabel = 'Ingreso';
    protected static ?string $pluralModelLabel = 'Ingresos';
    protected static ?string $navigationGroup = 'Transacciones';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ingre_monto')
                    ->label('Monto')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0.01)
                    ->columnSpan(['lg' => 1]),

                Forms\Components\DatePicker::make('ingre_fecha')
                    ->label('Fecha')
                    ->required()
                    ->default(now())
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Select::make('contpuc_idcontpuc')
                    ->label('Categoría')
                    ->options(function () {
                        return ContrapartidaPUC::where('estado', 'Activo')
                            ->where('contpuc_tipo', 'Ingreso')
                            ->get()
                            ->mapWithKeys(function ($contrapartida) {
                                return [$contrapartida->idcontpuc => "{$contrapartida->contpuc_codigo} - {$contrapartida->contpuc_descripcion}"];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Textarea::make('ingre_descripcion')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Select::make('usu_idusu')
                    ->label('Usuario')
                    ->options(function () {
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
                    ->visible(fn(string $operation): bool => $operation === 'edit')
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
                Tables\Columns\TextColumn::make('iding')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ingre_monto')
                    ->label('Monto')
                    ->money('COP')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ingre_fecha')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('contrapartida.contpuc_descripcion')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('contrapartida.contpuc_codigo')
                    ->label('Código')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                Tables\Columns\TextColumn::make('usuario.usua_nombre')
                    ->label('Usuario')
                    ->formatStateUsing(fn($record) => $record->usuario->usua_nombre)
                    ->searchable(),

                Tables\Columns\TextColumn::make('ingre_descripcion')
                    ->label('Descripción')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(
                        fn($record): string =>
                        $record->trashed()
                            ? 'danger'
                            : (($record->estado === 'Activo') ? 'success' : 'warning')
                    )
                    ->formatStateUsing(fn($record) => $record->trashed() ? 'Eliminado' : $record->estado),

                Tables\Columns\TextColumn::make('fecha_registro')
                    ->label('Fecha de Registro')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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

                Filter::make('ingre_fecha')
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
                                fn(Builder $query, $date): Builder => $query->whereDate('ingre_fecha', '>=', $date),
                            )
                            ->when(
                                $data['hasta'],
                                fn(Builder $query, $date): Builder => $query->whereDate('ingre_fecha', '<=', $date),
                            );
                    })
                    ->indicator(fn(array $data): ?string => $data['desde'] || $data['hasta'] ? 'Fechas filtradas' : null),
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
            'index' => Pages\ListIngresos::route('/'),
            'create' => Pages\CreateIngreso::route('/create'),
            'edit' => Pages\EditIngreso::route('/{record}/edit'),
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
