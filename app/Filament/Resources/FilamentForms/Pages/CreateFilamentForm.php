<?php

namespace App\Filament\Resources\FilamentForms\Pages;

use App\Filament\Resources\FilamentForms\FilamentFormResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFilamentForm extends CreateRecord
{
    protected static string $resource = FilamentFormResource::class;
}