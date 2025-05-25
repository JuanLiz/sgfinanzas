<?php

namespace App\Filament\Resources\ContrapartidaPUCResource\Pages;

use App\Filament\Resources\ContrapartidaPUCResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContrapartidaPUC extends CreateRecord
{
    protected static string $resource = ContrapartidaPUCResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
