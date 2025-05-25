<?php

namespace App\Filament\Resources\ContrapartidaPUCResource\Pages;

use App\Filament\Resources\ContrapartidaPUCResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContrapartidaPUC extends EditRecord
{
    protected static string $resource = ContrapartidaPUCResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
