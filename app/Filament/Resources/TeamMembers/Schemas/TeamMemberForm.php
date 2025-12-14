<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Personal Information')
                ->schema([
                    TextInput::make('name')
                        ->label('Name and Surname')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('role')
                        ->label('Role')
                        ->required()
                        ->maxLength(255),
                ])
                ->columns(2),

            Section::make('Biography')
                ->schema([
                    RichEditor::make('bio')
                        ->label('Short Biography')
                        ->columnSpanFull(),
                ]),

            Section::make('Profile Photo')
                ->schema([
                    FileUpload::make('photo')
                        ->label('Photo')
                        ->image()
                        ->required()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('team')
                        ->visibility('public')
                        ->maxSize(5120)
                ])
                ->collapsible(),

            Section::make('Publication')
                ->schema([
                    Toggle::make('is_published')
                        ->label('Visible on the site')
                        ->default(true),
                ]),
        ]);
    }
}