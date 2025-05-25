<?php

namespace App\Filament\Resources\CostoVariableResource\Pages;

use App\Filament\Resources\CostoVariableResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCostosVariables extends ListRecords
{
    protected static string $resource = CostoVariableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
