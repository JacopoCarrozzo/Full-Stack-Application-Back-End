<?php

namespace App\Filament\Resources\FilamentForms\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components;
use Filament\Schemas\Schema;                
use Filament\Schemas\Components\Utilities\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select; 
use Filament\Forms\Components\Toggle; 
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn; 
use Filament\Tables\Columns\IconColumn;
use Tapp\FilamentFormBuilder\Enums\FilamentFieldTypeEnum;

class FieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'fieldsRelation';

    protected static ?string $title = 'Form Fields';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Field Name')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label('Type')
                    ->options([
                        'TEXT'     => 'Text',
                        'TEXT'     => 'Email',     
                        'TEXTAREA' => 'Textarea',
                        'SELECT'   => 'Select',
                    ])
                    ->required()
                    ->live(onBlur: true),

                TextInput::make('label')
                    ->label('Label')
                    ->required()
                    ->maxLength(255),

                TextInput::make('placeholder')
                    ->label('Placeholder'),

                Toggle::make('required')
                    ->label('Required'),

                Textarea::make('hint')
                    ->label('Hint')
                    ->rows(2),

                Repeater::make('options')
                    ->label('Options (only for Select)')
                    ->visible(fn (Get $get): bool => $get('type') === 'SELECT')
                    ->columns(2)
                    ->schema([
                        TextInput::make('label')
                            ->label('Label')
                            ->required(),

                        TextInput::make('value')
                            ->label('Value')
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('label')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (FilamentFieldTypeEnum $state): string => match ($state) {
                        FilamentFieldTypeEnum::TEXT     => 'Text / Email', 
                        FilamentFieldTypeEnum::TEXTAREA => 'Textarea',
                        FilamentFieldTypeEnum::SELECT   => 'Select',
                        default                         => $state->name,
                    })
                    ->color(fn (FilamentFieldTypeEnum $state): string => match ($state) {
                        FilamentFieldTypeEnum::TEXT     => 'gray',
                        FilamentFieldTypeEnum::TEXTAREA => 'warning',
                        FilamentFieldTypeEnum::SELECT   => 'success',
                        default                         => 'primary',
                    }),

                IconColumn::make('required')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}