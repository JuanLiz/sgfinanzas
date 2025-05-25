<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CostoVariableResource\Pages;
use App\Models\ContrapartidaPUC;
use App\Models\CostoVariable;
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

class CostoVariableResource extends Resource
{
    protected static ?string $model = CostoVariable::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static ?string $modelLabel = 'Costo Variable';
    protected static ?string $pluralModelLabel = 'Costos Variables';
    protected static ?string $navigationGroup = 'Finanzas';
    protected static ?int $navigationSort = 50;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('costovariable_monto_promedio')
                    ->label('Monto promedio')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0.01)
                    ->columnSpan(['lg' => 1]),

                Forms\Components\TextInput::make('costovariable_variacion')
                    ->label('Variación estimada (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->suffix('%')
                    ->default(10)
                    ->required()
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Select::make('costovariable_frecuencia')
                    ->label('Frecuencia')
                    ->options([
                        'Mensual' => 'Mensual',
                        'Bimestral' => 'Bimestral',
                        'Trimestral' => 'Trimestral',
                        'Semestral' => 'Semestral',
                        'Anual' => 'Anual',
                        'Irregular' => 'Irregular',
                    ])
                    ->required()
                    ->columnSpan(['lg' => 2]),
                    
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

                Forms\Components\Textarea::make('costovariable_descripcion')
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
                Tables\Columns\TextColumn::make('idcostovariable')
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('costovariable_monto_promedio')
                    ->label('Monto promedio')
                    ->money('COP')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('costovariable_variacion')
                    ->label('Variación')
                    ->formatStateUsing(fn ($state) => number_format($state, 2) . '%')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('costovariable_frecuencia')
                    ->label('Frecuencia')
                    ->badge()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('contrapartida.contpuc_descripcion')
                    ->label('Categoría')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('usuario.usua_nombre')
                    ->label('Usuario')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('costovariable_descripcion')
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
                SelectFilter::make('costovariable_frecuencia')
                    ->options([
                        'Mensual' => 'Mensual',
                        'Bimestral' => 'Bimestral',
                        'Trimestral' => 'Trimestral',
                        'Semestral' => 'Semestral',
                        'Anual' => 'Anual',
                        'Irregular' => 'Irregular',
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
                    ->indicator('Usuario'),
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
            'index' => Pages\ListCostosVariables::route('/'),
            'create' => Pages\CreateCostoVariable::route('/create'),
            'edit' => Pages\EditCostoVariable::route('/{record}/edit'),
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
