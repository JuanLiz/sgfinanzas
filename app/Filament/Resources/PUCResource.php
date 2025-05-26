<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PUCResource\Pages;
use App\Models\PUC;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PUCResource extends Resource
{
    protected static ?string $model = PUC::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $modelLabel = 'PUC';
    protected static ?string $pluralModelLabel = 'PUCs';
    protected static ?string $navigationGroup = 'Contabilidad';
    protected static ?int $navigationSort = 10;
    
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('puc_codigo')
                    ->label('Código')
                    ->required()
                    ->maxLength(4)
                    ->minLength(4)
                    ->numeric()
                    ->unique(ignoreRecord: true)
                    ->helperText('Código de 4 dígitos para la cuenta PUC')
                    ->columnSpan(['lg' => 1]),

                Forms\Components\TextInput::make('puc_descripcion')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Select::make('puc_naturaleza')
                    ->label('Naturaleza')
                    ->options([
                        'Deudora' => 'Deudora',
                        'Acreedora' => 'Acreedora',
                    ])
                    ->required()
                    ->columnSpan(['lg' => 1]),

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
                Tables\Columns\TextColumn::make('idpuc')
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('puc_codigo')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('puc_descripcion')
                    ->label('Descripción')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('puc_naturaleza')
                    ->label('Naturaleza')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Deudora' => 'info',
                        'Acreedora' => 'warning',
                        default => 'gray',
                    })
                    ->searchable(),
                    
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
            \App\Filament\Resources\PUCResource\RelationManagers\ContrapartidasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPUCS::route('/'),
            'create' => Pages\CreatePUC::route('/create'),
            'edit' => Pages\EditPUC::route('/{record}/edit'),
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
