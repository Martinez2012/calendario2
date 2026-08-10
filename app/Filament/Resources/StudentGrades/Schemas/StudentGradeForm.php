<?php

namespace App\Filament\Resources\StudentGrades\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StudentGradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('student_id')
                    ->required()
                    ->numeric(),
                TextInput::make('task_submission_id')
                    ->numeric(),
                TextInput::make('score')
                    ->required()
                    ->numeric(),
                Textarea::make('observations')
                    ->columnSpanFull(),
            ]);
    }
}
