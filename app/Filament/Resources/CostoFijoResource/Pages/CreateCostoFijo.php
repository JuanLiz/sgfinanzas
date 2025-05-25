<?php

namespace App\Filament\Resources\CostoFijoResource\Pages;

use App\Filament\Resources\CostoFijoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCostoFijo extends CreateRecord
{
    protected static string $resource = CostoFijoResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
