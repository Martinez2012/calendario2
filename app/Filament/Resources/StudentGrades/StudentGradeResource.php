<?php

namespace App\Filament\Resources\StudentGrades;

use App\Filament\Resources\StudentGrades\Pages\CreateStudentGrade;
use App\Filament\Resources\StudentGrades\Pages\EditStudentGrade;
use App\Filament\Resources\StudentGrades\Pages\ListStudentGrades;
use App\Filament\Resources\StudentGrades\Schemas\StudentGradeForm;
use App\Filament\Resources\StudentGrades\Tables\StudentGradesTable;
use App\Models\StudentGrade;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentGradeResource extends Resource
{
    protected static ?string $model = StudentGrade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'celificacion del estudiante';

    public static function form(Schema $schema): Schema
    {
        return StudentGradeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentGradesTable::configure($table);
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
            'index' => ListStudentGrades::route('/'),
            'create' => CreateStudentGrade::route('/create'),
            'edit' => EditStudentGrade::route('/{record}/edit'),
        ];
    }
}
