<?php

namespace App\Filament\AdminPanel\Resources\PageResource\Pages;

use App\Filament\AdminPanel\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;
}
