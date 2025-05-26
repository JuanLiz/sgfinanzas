<?php

namespace App\Filament\Resources\MetaAhorroResource\Pages;

use App\Filament\Resources\MetaAhorroResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMetaAhorro extends CreateRecord
{
    protected static string $resource = MetaAhorroResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    // Automáticamente asociar la meta de ahorro al usuario autenticado
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!auth()->user()->isAdmin()) {
            $data['usu_idusu'] = auth()->id();
        }
        
        return $data;
    }
}
