<?php

namespace App\Filament\Resources\PUCResource\RelationManagers;

use App\Models\ContrapartidaPUC;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContrapartidasRelationManager extends RelationManager
{
    protected static string $relationship = 'contrapartidas';

    protected static ?string $recordTitleAttribute = 'contpuc_descripcion';

    public function form(Form $form): Form
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
                    ->helperText('Código de 6 dígitos para la contrapartida'),

                Forms\Components\TextInput::make('contpuc_descripcion')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('contpuc_tipo')
                    ->label('Tipo')
                    ->options([
                        'Ingreso' => 'Ingreso',
                        'Egreso' => 'Egreso',
                    ])
                    ->required(),

                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Inactivo' => 'Inactivo',
                    ])
                    ->default('Activo')
                    ->required()
                    ->visible(fn (string $operation): bool => $operation === 'edit'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('contpuc_descripcion')
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
                    
                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Activo' => 'success',
                        'Inactivo' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('contpuc_tipo')
                    ->options([
                        'Ingreso' => 'Ingreso',
                        'Egreso' => 'Egreso',
                    ])
                    ->label('Tipo'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
