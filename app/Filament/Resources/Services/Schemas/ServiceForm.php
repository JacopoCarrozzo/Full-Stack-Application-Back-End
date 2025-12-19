<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Psyao\FilamentIconPicker\Forms\IconPicker;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->rows(4),

                IconPicker::make('icon')
                    ->label('Service Icon')
                    ->sets(['lucide'])
                    ->required()
                    ->columnSpanFull()
                    ->columns(10)
                    ->selectAction(fn (Action $action) => $action
                        ->label('Choose Icon')
                        ->icon('heroicon-m-cube')
                        ->color('primary')
                        ->modalWidth('7xl')
                    ),


                Toggle::make('is_published')
                    ->label('Published')
                    ->default(true)
                    ->inline(false),

                TextInput::make('sort_order')
                    ->label('Display order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}