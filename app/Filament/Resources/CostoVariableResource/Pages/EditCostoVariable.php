<?php

namespace App\Filament\Resources\CostoVariableResource\Pages;

use App\Filament\Resources\CostoVariableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCostoVariable extends EditRecord
{
    protected static string $resource = CostoVariableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
