<?php

namespace App\Filament\Resources\NewslettersResource\Pages;

use App\Filament\Resources\NewslettersResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsletters extends ListRecords
{
    protected static string $resource = NewslettersResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
