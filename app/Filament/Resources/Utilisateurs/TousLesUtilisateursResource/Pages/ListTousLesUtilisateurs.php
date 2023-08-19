<?php

namespace App\Filament\Resources\TousLesUtilisateursResource\Pages;

use App\Filament\Resources\TousLesUtilisateursResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTousLesUtilisateurs extends ListRecords
{
    protected static string $resource = TousLesUtilisateursResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
