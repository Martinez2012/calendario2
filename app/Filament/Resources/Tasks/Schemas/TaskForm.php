<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\TeacherSubjectGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('teacher_subject_group_id')
                    ->label('Asignación (Profesor / Materia / Grupo)')
                    ->relationship(name: 'teacherSubjectGroup', titleAttribute: 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn (TeacherSubjectGroup $record): string =>
                            "{$record->teacher->user->name} — {$record->subject->name} — {$record->group->name}"
                    )
                    ->getSearchResultsUsing(
                        fn (string $search) => TeacherSubjectGroup::with(['teacher.user', 'subject', 'group'])
                            ->whereHas('teacher.user', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('subject', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('group', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn (TeacherSubjectGroup $item) => [
                                $item->id => "{$item->teacher->user->name} — {$item->subject->name} — {$item->group->name}",
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->prefixIcon('heroicon-o-link')
                    ->helperText('Busca por nombre del profesor, materia o grupo.')
                    ->columnSpanFull(),

                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),

                DateTimePicker::make('assigned_at')
                    ->label('Fecha de asignación')
                    ->native(false)
                    ->displayFormat('d/m/Y H:i')
                    ->required(),

                DateTimePicker::make('due_at')
                    ->label('Fecha de entrega')
                    ->native(false)
                    ->displayFormat('d/m/Y H:i')
                    ->required()
                    ->after('assigned_at'),

            ]);
    }
}