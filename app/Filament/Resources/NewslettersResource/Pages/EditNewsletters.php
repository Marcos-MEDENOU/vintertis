<?php

namespace App\Filament\Resources\NewslettersResource\Pages;

use App\Filament\Resources\NewslettersResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsletters extends EditRecord
{
    protected static string $resource = NewslettersResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
