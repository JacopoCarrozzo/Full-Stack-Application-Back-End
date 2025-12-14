<?php

namespace App\Filament\Resources\FilamentForms\Schemas;

use Filament\Forms\Components;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;



class FormSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Form Name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Get $get, Set $set, ?string $state) =>
                        $set('slug', $state ? Str::slug($state) : null)
                    ),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->alphaDash()
                    ->maxLength(255)
                    ->helperText('Leave empty to auto-generate from the name'),

                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),

                Toggle::make('permit_guest_entries')
                    ->label('Allow submissions without login')
                    ->default(true),

                TextInput::make('redirect_url')
                    ->label('Redirect URL after submission')
                    ->url()
                    ->placeholder('https://example.com/thank-you'),

                TextInput::make('notification_emails')
                    ->label('Notification emails (comma separated)')
                    ->helperText('E.g. email1@example.com, email2@example.com'),
            ]);
    }
}