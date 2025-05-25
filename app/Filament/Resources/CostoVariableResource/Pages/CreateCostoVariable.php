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
}
