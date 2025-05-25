<?php

namespace App\Filament\Resources\CostoFijoResource\Pages;

use App\Filament\Resources\CostoFijoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCostosFijos extends ListRecords
{
    protected static string $resource = CostoFijoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
