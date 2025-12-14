<?php

namespace App\Filament\Resources\FilamentForms;

use App\Filament\Resources\FilamentForms\Pages\ListFilamentForms;
use App\Filament\Resources\FilamentForms\Pages\CreateFilamentForm;
use App\Filament\Resources\FilamentForms\Pages\EditFilamentForm;
use App\Filament\Resources\FilamentForms\Schemas\FormSchema;
use App\Filament\Resources\FilamentForms\Tables\FormTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use App\Filament\Resources\FilamentForms\RelationManagers\FieldsRelationManager;
use App\Models\FilamentForm;

class FilamentFormResource extends Resource
{
    protected static ?string $model = FilamentForm::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelopeOpen;

    protected static ?string $navigationLabel = 'Forms Builder';

    protected static ?string $modelLabel = 'Custom Form'; 
    
    protected static ?string $pluralModelLabel = 'Form Management';

    public static function form(Schema $schema): Schema
    {
        return FormSchema::configure($schema);
    }

    public static function getModel(): string
    {
        return FilamentForm::class;
    }

    public static function table(Table $table): Table
    {
        return FormTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            FieldsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFilamentForms::route('/'),
            'create' => CreateFilamentForm::route('/create'),
            'edit' => EditFilamentForm::route('/{record}/edit'),
        ];
    }
}