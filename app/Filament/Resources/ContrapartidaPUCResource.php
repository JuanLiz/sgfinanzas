<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContrapartidaPUCResource\Pages;
use App\Models\ContrapartidaPUC;
use App\Models\PUC;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContrapartidaPUCResource extends Resource
{
    protected static ?string $model = ContrapartidaPUC::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $modelLabel = 'Contrapartida PUC';
    protected static ?string $pluralModelLabel = 'Contrapartidas PUC';
    protected static ?string $navigationGroup = 'Contabilidad';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('contpuc_codigo')
                    ->label('Código')
                    ->required()
                    ->maxLength(6)
                    ->minLength(6)
                    ->numeric()
                    ->unique(ignoreRecord: true)
                    ->helperText('Código de 6 dígitos para la contrapartida')
                    ->columnSpan(['lg' => 1]),

                Forms\Components\TextInput::make('contpuc_descripcion')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Select::make('contpuc_tipo')
                    ->label('Tipo')
                    ->options([
                        'Ingreso' => 'Ingreso',
                        'Egreso' => 'Egreso',
                    ])
                    ->required()
                    ->columnSpan(['lg' => 1]),

                Forms\Components\Select::make('puc_idpuc')
                    ->label('Cuenta PUC')
                    ->options(function() {
                        return PUC::where('estado', 'Activo')
                            ->get()
                            ->mapWithKeys(function ($puc) {
                                return [$puc->idpuc => "{$puc->puc_codigo} - {$puc->puc_descripcion} ({$puc->puc_naturaleza})"];
                            });
                    })
                    ->searchable()
                    ->required()
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Inactivo' => 'Inactivo',
                    ])
                    ->default('Activo')
                    ->required()
                    ->visible(fn (string $operation): bool => $operation === 'edit'),

                Forms\Components\DateTimePicker::make('fecha_registro')
                    ->label('Fecha de Registro')
                    ->disabled()
                    ->visibleOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('idcontpuc')
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('contpuc_codigo')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('contpuc_descripcion')
                    ->label('Descripción')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('contpuc_tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Ingreso' => 'success',
                        'Egreso' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('puc.puc_codigo')
                    ->label('Código PUC')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('puc.puc_descripcion')
                    ->label('Descripción PUC')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('puc.puc_naturaleza')
                    ->label('Naturaleza PUC')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Deudora' => 'info',
                        'Acreedora' => 'warning',
                        default => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                    
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn ($record): string => 
                        $record->trashed()
                            ? 'danger'
                            : (($record->estado === 'Activo') ? 'success' : 'warning')
                    )
                    ->formatStateUsing(fn ($record) => $record->trashed() ? 'Eliminado' : $record->estado)
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('fecha_registro')
                    ->label('Fecha de Registro')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('contpuc_tipo')
                    ->options([
                        'Ingreso' => 'Ingreso',
                        'Egreso' => 'Egreso',
                    ])
                    ->label('Tipo')
                    ->indicator('Tipo'),
                SelectFilter::make('puc_idpuc')
                    ->relationship('puc', 'puc_descripcion')
                    ->label('Cuenta PUC')
                    ->indicator('Cuenta PUC'),
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
            'index' => Pages\ListContrapartidaPUCS::route('/'),
            'create' => Pages\CreateContrapartidaPUC::route('/create'),
            'edit' => Pages\EditContrapartidaPUC::route('/{record}/edit'),
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
