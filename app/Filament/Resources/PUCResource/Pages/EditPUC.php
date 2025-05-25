<?php

namespace App\Filament\Resources\PUCResource\Pages;

use App\Filament\Resources\PUCResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPUC extends EditRecord
{
    protected static string $resource = PUCResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
