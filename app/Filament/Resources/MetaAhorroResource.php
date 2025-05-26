<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetaAhorroResource\Pages;
use App\Models\MetaAhorro;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class MetaAhorroResource extends Resource
{
    protected static ?string $model = MetaAhorro::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $modelLabel = 'Meta de ahorro';
    protected static ?string $pluralModelLabel = 'Metas de ahorro';
    protected static ?string $navigationGroup = 'Finanzas';
    protected static ?int $navigationSort = 60; // Después de costos variables

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('metah_monto')
                    ->label('Monto objetivo')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0.01)
                    ->columnSpan(['lg' => 1]),

                Forms\Components\TextInput::make('metah_monto_actual')
                    ->label('Monto actual')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->default(0)
                    ->columnSpan(['lg' => 1]),

                Forms\Components\DatePicker::make('metah_fecha_meta')
                    ->label('Fecha objetivo')
                    ->required()
                    ->minDate(now())
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Select::make('metah_periodo')
                    ->label('Periodo de ahorro')
                    ->options([
                        'Diario' => 'Diario',
                        'Semanal' => 'Semanal',
                        'Quincenal' => 'Quincenal',
                        'Mensual' => 'Mensual',
                        'Bimestral' => 'Bimestral',
                        'Trimestral' => 'Trimestral',
                        'Semestral' => 'Semestral',
                        'Anual' => 'Anual',
                        'Irregular' => 'Irregular',
                    ])
                    ->required()
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Textarea::make('metah_descripcion')
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
                    ->visible(fn() => auth()->user()->isAdmin())
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Inactivo' => 'Inactivo',
                        'Completado' => 'Completado',
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
            ->modifyQueryUsing(function (Builder $query) {
                // Si no es administrador, filtrar solo por el usuario autenticado
                if (!auth()->user()->isAdmin()) {
                    $query->where('usu_idusu', auth()->id());
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('idmetah')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('metah_descripcion')
                    ->label('Descripción')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('metah_monto')
                    ->label('Monto objetivo')
                    ->money('COP')
                    ->sortable(),

                Tables\Columns\TextColumn::make('metah_monto_actual')
                    ->label('Monto actual')
                    ->money('COP')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('porcentaje_progreso')
                    ->label('Progreso')
                    ->formatStateUsing(function ($record) {
                        if (!$record || !$record->metah_monto) {
                            return '0.00%';
                        }
                        return number_format($record->getPorcentajeProgresoAttribute(), 2) . '%';
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderByRaw('(metah_monto_actual / nullif(metah_monto, 0)) * 100 ' . $direction);
                    })
                    ->color(function ($record) {
                        if (!$record || !$record->metah_monto) {
                            return 'gray';
                        }
                        return $record->getPorcentajeProgresoAttribute() >= 100 ? 'success' : 'warning';
                    }),

                Tables\Columns\TextColumn::make('metah_periodo')
                    ->label('Periodo')
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('metah_fecha_meta')
                    ->label('Fecha objetivo')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('usuario.usua_nombre')
                    ->label('Usuario')
                    ->visible(fn() => auth()->user()->isAdmin())
                    ->searchable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(
                        fn($record): string =>
                        $record->trashed()
                            ? 'danger'
                            : (($record->estado === 'Activo') ? 'success' : ($record->estado === 'Completado' ? 'info' : 'warning'))
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
                SelectFilter::make('metah_periodo')
                    ->options([
                        'Diario' => 'Diario',
                        'Semanal' => 'Semanal',
                        'Quincenal' => 'Quincenal',
                        'Mensual' => 'Mensual',
                        'Bimestral' => 'Bimestral',
                        'Trimestral' => 'Trimestral',
                        'Semestral' => 'Semestral',
                        'Anual' => 'Anual',
                        'Irregular' => 'Irregular',
                    ])
                    ->label('Periodo')
                    ->indicator('Periodo'),

                SelectFilter::make('estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Inactivo' => 'Inactivo',
                        'Completado' => 'Completado',
                    ])
                    ->label('Estado')
                    ->indicator('Estado'),

                SelectFilter::make('usu_idusu')
                    ->relationship('usuario', 'usua_nombre')
                    ->label('Usuario')
                    ->searchable()
                    ->preload()
                    ->visible(fn() => auth()->user()->isAdmin())
                    ->indicator('Usuario'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\Action::make('marcarCompletado')
                    ->label('Completar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => $record->metah_monto_actual < $record->metah_monto)
                    ->action(function (MetaAhorro $record) {
                        $record->metah_monto_actual = $record->metah_monto;
                        $record->save();
                        
                        Notification::make()
                            ->success()
                            ->title('Meta de ahorro completada con éxito.')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListMetasAhorro::route('/'),
            'create' => Pages\CreateMetaAhorro::route('/create'),
            'edit' => Pages\EditMetaAhorro::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    // Control de acceso - solo admin puede ver todos los registros
    public static function canAccess(): bool
    {
        return auth()->check();
    }
}
