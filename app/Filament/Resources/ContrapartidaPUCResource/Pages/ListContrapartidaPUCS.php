<?php

namespace App\Filament\Resources\ContrapartidaPUCResource\Pages;

use App\Filament\Resources\ContrapartidaPUCResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContrapartidaPUCS extends ListRecords
{
    protected static string $resource = ContrapartidaPUCResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
