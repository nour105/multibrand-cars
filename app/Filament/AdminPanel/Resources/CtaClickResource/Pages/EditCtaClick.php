<?php

namespace App\Filament\AdminPanel\Resources\CtaClickResource\Pages;

use App\Filament\AdminPanel\Resources\CtaClickResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCtaClick extends EditRecord
{
    protected static string $resource = CtaClickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
