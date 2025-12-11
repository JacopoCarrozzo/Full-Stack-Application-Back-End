<?php

namespace App\Filament\Resources\TeamMembers\Pages;

use App\Filament\Resources\TeamMembers\TeamMembersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamMembers extends ListRecords
{
    protected static string $resource = TeamMembersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}