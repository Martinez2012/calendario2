<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('type')
                    ->required(),
                DateTimePicker::make('start')
                    ->required(),
                DateTimePicker::make('end')
                    ->required(),
                TextInput::make('group_id')
                    ->numeric(),
                TextInput::make('teacher_subject_group_id')
                    ->numeric(),
            ]);
    }
}
