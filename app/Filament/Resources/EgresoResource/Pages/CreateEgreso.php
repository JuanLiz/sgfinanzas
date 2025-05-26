<?php

namespace App\Filament\Resources\EgresoResource\Pages;

use App\Filament\Resources\EgresoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEgreso extends CreateRecord
{
    protected static string $resource = EgresoResource::class;
    
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
