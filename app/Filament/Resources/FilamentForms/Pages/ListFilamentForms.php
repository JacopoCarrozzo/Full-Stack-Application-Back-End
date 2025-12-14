<?php

namespace App\Filament\Resources\FilamentForms\Pages;

use App\Filament\Resources\FilamentForms\FilamentFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFilamentForms extends ListRecords
{
    protected static string $resource = FilamentFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}