<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('student_code')
                    ->required(),
                TextInput::make('document')
                    ->required(),
                DatePicker::make('birth_date'),
                TextInput::make('guardian_name'),
                TextInput::make('guardian_phone')
                    ->tel(),
            ]);
    }
}
