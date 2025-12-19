<?php

namespace App\Filament\Resources\Pages\Schemas;

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
                            ->helperText('Generated from the title if empty.'),
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
                                            ->disk('public')
                                            ->directory('page-images')
                                            ->required(),

                                        TextInput::make('alt')
                                            ->label('ALT text')
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
                                            ->columnSpanFull(),

                                        Section::make('Grid Options')
                                            ->schema([
                                                Select::make('columns')
                                                    ->label('Columns')
                                                    ->options([
                                                        '2' => '2 columns',
                                                        '3' => '3 columns',
                                                        '4' => '4 columns',
                                                    ])
                                                    ->default('3')
                                                    ->required(),

                                                Toggle::make('show_bio')
                                                    ->label('Show biography')
                                                    ->default(true),
                                            ])
                                            ->columns(2),

                                        Repeater::make('members')
                                            ->label('Team Members')
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
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state) =>
                                                \App\Models\TeamMember::find($state['team_member_id'])?->name
                                            ),
                                    ]),

                                Block::make('custom-form')
                                    ->label('Custom Form')
                                    ->icon('heroicon-o-envelope')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Title Above Form')
                                            ->default('Contact Us')
                                            ->columnSpanFull(),

                                        Select::make('form_id')
                                            ->label('Select Form')
                                            ->options(FilamentForm::pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
                                    ]),

                                Block::make('services-grid')
                                    ->label('Services Grid')
                                    ->icon('heroicon-o-code-bracket')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Section Title')
                                            ->default('Our services')
                                            ->columnSpanFull(),

                                        Repeater::make('items')
                                            ->label('Services')
                                            ->schema([
                                                Select::make('service_id')
                                                    ->label('Service')
                                                    ->options(
                                                        \App\Models\Service::where('is_published', true)
                                                            ->orderBy('sort_order')
                                                            ->pluck('title', 'id')
                                                    )
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => 
                                                \App\Models\Service::find($state['service_id'])?->title ?? null
                                            )
                                            ->defaultItems(3)
                                            ->columnSpanFull(),
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
                    ]),
            ]);
    }
}
