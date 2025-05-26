<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartamentoResource\Pages;
use App\Models\Departamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartamentoResource extends Resource
{
    protected static ?string $model = Departamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $modelLabel = 'Departamento';
    protected static ?string $pluralModelLabel = 'Departamentos';
    protected static ?string $navigationGroup = 'Configuración general';
    protected static ?int $navigationSort = 10;
    
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('depar_nombre')
                    ->label('Nombre del Departamento')
                    ->required()
                    ->maxLength(45)
                    ->columnSpan('full'),
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
                    ->default(now())
                    ->visibleOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('iddepar')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('depar_nombre')
                    ->label('Nombre del Departamento')
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
                    ->sortable(),
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
            \App\Filament\Resources\DepartamentoResource\RelationManagers\MunicipiosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartamentos::route('/'),
            'create' => Pages\CreateDepartamento::route('/create'),
            'edit' => Pages\EditDepartamento::route('/{record}/edit'),
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
