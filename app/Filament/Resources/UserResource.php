<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Role;
use App\Models\Municipio;
use App\Models\Departamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';
    protected static ?string $navigationGroup = 'Administración de acceso';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('usua_nombre')
                    ->label('Nombre Completo')
                    ->required()
                    ->maxLength(45)
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255)
                    ->columnSpan('full'),
                Forms\Components\Select::make('rol_idrol')
                    ->label('Rol')
                    ->options(Role::all()->pluck('rol_descripcion', 'idrol'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('muni_idmuni')
                    ->label('Municipio')
                    ->options(function () {
                        return Municipio::with('departamento')
                            ->get()
                            ->mapWithKeys(function ($municipio) {
                                $departamento = $municipio->departamento ? $municipio->departamento->depar_nombre : 'Sin departamento';
                                return [$municipio->idmuni => "{$municipio->muni_nombre} ({$departamento})"];
                            });
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Inactivo' => 'Inactivo',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label('Email Verificado en')
                    ->disabled()
                    ->visibleOn('edit'),
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
                Tables\Columns\TextColumn::make('idusu')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('usua_nombre')->label('Nombre')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Correo Electrónico')->searchable(),
                Tables\Columns\TextColumn::make('role.rol_descripcion')->label('Rol')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('municipio.departamento.depar_nombre')->label('Departamento')->searchable(),
                Tables\Columns\TextColumn::make('municipio.muni_nombre')->label('Municipio')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('estado')->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Activo' => 'success',
                        'Inactivo' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')->label('Email Verificado')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fecha_registro')->label('Fecha Registro')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
