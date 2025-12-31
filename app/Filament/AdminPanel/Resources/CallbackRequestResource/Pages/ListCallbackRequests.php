<?php

namespace App\Filament\AdminPanel\Resources\CallbackRequestResource\Pages;

use App\Filament\AdminPanel\Resources\CallbackRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCallbackRequests extends ListRecords
{
    protected static string $resource = CallbackRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
