<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('student_id')
                    ->required()
                    ->numeric(),
                TextInput::make('group_id')
                    ->required()
                    ->numeric(),
                TextInput::make('school_year')
                    ->required()
                    ->numeric(),
            ]);
    }
}
