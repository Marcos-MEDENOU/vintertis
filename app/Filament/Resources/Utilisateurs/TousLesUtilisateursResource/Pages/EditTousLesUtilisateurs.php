<?php

namespace App\Filament\Resources\TousLesUtilisateursResource\Pages;

use App\Filament\Resources\TousLesUtilisateursResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTousLesUtilisateurs extends EditRecord
{
    protected static string $resource = TousLesUtilisateursResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
