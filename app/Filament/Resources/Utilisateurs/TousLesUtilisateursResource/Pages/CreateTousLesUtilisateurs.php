<?php

namespace App\Filament\Resources\TousLesUtilisateursResource\Pages;

use App\Filament\Resources\TousLesUtilisateursResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTousLesUtilisateurs extends CreateRecord
{
    protected static string $resource = TousLesUtilisateursResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl();
    }
}
