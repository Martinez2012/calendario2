<?php

namespace App\Filament\Resources\TeacherSubjectGroups;

use App\Filament\Resources\TeacherSubjectGroups\Pages\CreateTeacherSubjectGroup;
use App\Filament\Resources\TeacherSubjectGroups\Pages\EditTeacherSubjectGroup;
use App\Filament\Resources\TeacherSubjectGroups\Pages\ListTeacherSubjectGroups;
use App\Filament\Resources\TeacherSubjectGroups\Schemas\TeacherSubjectGroupForm;
use App\Filament\Resources\TeacherSubjectGroups\Tables\TeacherSubjectGroupsTable;
use App\Models\TeacherSubjectGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TeacherSubjectGroupResource extends Resource
{
    protected static ?string $model = TeacherSubjectGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static ?string $navigationLabel = 'Asignaciones de Profesores';

    protected static ?string $modelLabel = 'Asignación';

    protected static ?string $pluralModelLabel = 'Asignaciones de Profesores';
    public static function form(Schema $schema): Schema
    {
        return TeacherSubjectGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeacherSubjectGroupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeacherSubjectGroups::route('/'),
            'create' => CreateTeacherSubjectGroup::route('/create'),
            'edit' => EditTeacherSubjectGroup::route('/{record}/edit'),
        ];
    }
}
