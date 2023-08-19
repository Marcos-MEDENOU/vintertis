<?php

namespace App\Filament\Resources\BlocksResource\Pages;

use App\Filament\Resources\BlocksResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlocks extends EditRecord
{
    protected static string $resource = BlocksResource::class;

    protected ?string $maxContentWidth = 'full';

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
