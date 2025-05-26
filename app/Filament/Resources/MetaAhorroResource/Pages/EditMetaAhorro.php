<?php

namespace App\Filament\Resources\MetaAhorroResource\Pages;

use App\Filament\Resources\MetaAhorroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class EditMetaAhorro extends EditRecord
{
    protected static string $resource = MetaAhorroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\Action::make('marcarCompletado')
                ->label('Completar meta')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => $record->metah_monto_actual < $record->metah_monto)
                ->action(function () {
                    $this->record->metah_monto_actual = $this->record->metah_monto;
                    $this->record->save();
                    
                    Notification::make()
                        ->success()
                        ->title('Meta de ahorro completada con éxito.')
                        ->send();
                }),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
