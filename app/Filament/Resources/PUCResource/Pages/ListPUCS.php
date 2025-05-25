<?php

namespace App\Filament\Resources\PUCResource\Pages;

use App\Filament\Resources\PUCResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPUCS extends ListRecords
{
    protected static string $resource = PUCResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
