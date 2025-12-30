<?php

namespace App\Filament\AdminPanel\Resources\LeadResource\Pages;

use App\Filament\AdminPanel\Resources\LeadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;
}
