<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Schemas\Schema; 
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set; 

class MenuForm
{
    /**
     * Configures the form schema for Menu Resource.
     * @param Schema $schema The schema instance being configured.
     * @return Schema
     */
    public static function configure(Schema $schema): Schema 
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Menu Name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->live(onBlur: true) 
                    
                    ->afterStateUpdated(function (string $operation, $state, Set $set) { 
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                ]);
    }
}