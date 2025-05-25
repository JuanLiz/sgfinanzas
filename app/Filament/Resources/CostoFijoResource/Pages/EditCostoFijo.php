<?php

namespace App\Filament\Resources\CostoFijoResource\Pages;

use App\Filament\Resources\CostoFijoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCostoFijo extends EditRecord
{
    protected static string $resource = CostoFijoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
