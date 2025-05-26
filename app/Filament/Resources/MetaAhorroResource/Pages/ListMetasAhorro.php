<?php

namespace App\Filament\Resources\MetaAhorroResource\Pages;

use App\Filament\Resources\MetaAhorroResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMetasAhorro extends ListRecords
{
    protected static string $resource = MetaAhorroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
