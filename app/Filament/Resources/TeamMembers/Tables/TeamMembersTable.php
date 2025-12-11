<?php

namespace App\Filament\Resources\TeamMembers\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions;

class TeamMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->height(60)
                    ->width(60)
                    ->rounded(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->searchable(),

                ToggleColumn::make('is_published'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Actions\EditAction::make(),      
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}