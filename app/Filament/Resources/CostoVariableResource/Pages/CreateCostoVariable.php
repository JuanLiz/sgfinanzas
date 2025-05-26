<?php

namespace App\Filament\Resources\CostoVariableResource\Pages;

use App\Filament\Resources\CostoVariableResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCostoVariable extends CreateRecord
{
    protected static string $resource = CostoVariableResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Solo asignar el usuario autenticado si:
        // 1. El usuario no es administrador, o
        // 2. No se ha seleccionado un usuario explícitamente
        if (!auth()->user()->isAdmin() || empty($data['usu_idusu'])) {
            $data['usu_idusu'] = auth()->id();
        }
        
        return $data;
    }
}
