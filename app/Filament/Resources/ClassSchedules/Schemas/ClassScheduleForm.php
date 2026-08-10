<?php

namespace App\Filament\Resources\ClassSchedules\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ClassScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('teacher_subject_group_id')
                    ->required()
                    ->numeric(),
                TextInput::make('day_of_week')
                    ->required()
                    ->numeric(),
                TimePicker::make('start_time')
                    ->required(),
                TimePicker::make('end_time')
                    ->required(),
            ]);
    }
}
