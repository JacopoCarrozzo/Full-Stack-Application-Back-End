<?php

namespace App\Filament\Resources\Pages\Schemas;

use Closure;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Tapp\FilamentFormBuilder\Models\FilamentForm;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->state([
                'is_published' => false,
            ])
            ->components([
                Section::make('Main Details')
                    ->description('Basic page information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                if (empty($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('The slug is automatically generated from the title and updated only if empty (on blur).'),
                    ])
                    ->columns(2),

                Section::make('Content')
                    ->description('Manage page content blocks')
                    ->schema([
                        Builder::make('content')
                            ->label('Content Blocks')
                            ->blocks([
                                Block::make('heading')
                                    ->label('Header')
                                    ->icon('heroicon-o-hashtag')
                                    ->schema([
                                        Select::make('level')
                                            ->label('Level')
                                            ->options([
                                                'h1' => 'H1',
                                                'h2' => 'H2',
                                                'h3' => 'H3',
                                                'h4' => 'H4',
                                            ])
                                            ->default('h2')
                                            ->required(),

                                        TextInput::make('text')
                                            ->label('Header Text')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Block::make('text')
                                    ->label('Text')
                                    ->icon('heroicon-o-pencil-square')
                                    ->schema([
                                        RichEditor::make('body')
                                            ->label('Body of the Text')
                                            ->required(),
                                    ]),

                                Block::make('image')
                                    ->label('Image')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        FileUpload::make('url')
                                            ->label('Upload Image')
                                            ->image()
                                            ->required()
                                            ->disk('public')
                                            ->directory('page-images'),

                                        TextInput::make('alt')
                                            ->label('Alternative Text (ALT)')
                                            ->maxLength(255),

                                        TextInput::make('caption')
                                            ->label('Caption')
                                            ->maxLength(255),
                                    ]),

                                Block::make('team-grid')
                                    ->label('Team Members')
                                    ->icon('heroicon-o-user-group')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Section Title')
                                            ->default('Meet the Team')
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        Section::make('Grid Options')
                                            ->schema([
                                                Select::make('columns')
                                                    ->label('Number of Columns')
                                                    ->options([
                                                        '2' => '2 columns',
                                                        '3' => '3 columns',
                                                        '4' => '4 columns',
                                                    ])
                                                    ->default('3')
                                                    ->required(),

                                                Toggle::make('show_bio')
                                                    ->label('Show Biography')
                                                    ->default(true),
                                            ])
                                            ->columns(2),

                                        Repeater::make('members')
                                            ->label('Select Team Members')
                                            ->schema([
                                                Select::make('team_member_id')
                                                    ->label('Member')
                                                    ->options(
                                                        \App\Models\TeamMember::query()
                                                            ->where('is_published', true)
                                                            ->orderBy('name')
                                                            ->pluck('name', 'id')
                                                    )
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                            ])
                                            ->columns(3)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string =>
                                                \App\Models\TeamMember::find($state['team_member_id'])?->name ?? null
                                            ),
                                    ]),

                                Block::make('custom-form')
                                    ->label('Custom Form')
                                    ->icon('heroicon-o-envelope')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Title Above Form')
                                            ->placeholder('Ex. "Contact Us", "Subscribe to newsletter"')
                                            ->default('Contact Us')
                                            ->columnSpanFull(),

                                        Select::make('form_id')
                                            ->label('Select Form')
                                            ->options(FilamentForm::pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
                                    ]),
                            ])
                            ->collapsible(),
                    ]),

                Section::make('Publication')
                    ->description('Publication status')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(false),
                    ])
                    ->columns(1),
            ]);
    }
}