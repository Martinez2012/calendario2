<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Models\TeacherSubjectGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-megaphone')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),

                Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'holiday' => 'Feriado',
                        'exam' => 'Examen',
                        'meeting' => 'Reunión',
                        'activity' => 'Actividad',
                    ])
                    ->required()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-tag')
                    ->helperText('El tipo determina si el evento se vincula a una asignación específica o a un grupo general.')
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state === 'exam') {
                            $set('group_id', null);
                        } else {
                            $set('teacher_subject_group_id', null);
                        }
                    }),

                DateTimePicker::make('start')
                    ->label('Inicio')
                    ->native(false)
                    ->displayFormat('d/m/Y H:i')
                    ->required()
                    ->live(),

                DateTimePicker::make('end')
                    ->label('Fin')
                    ->native(false)
                    ->displayFormat('d/m/Y H:i')
                    ->required()
                    ->after('start'),

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
                    ->native(false)
                    ->prefixIcon('heroicon-o-link')
                    ->visible(fn (Get $get) => $get('type') === 'exam')
                    ->required(fn (Get $get) => $get('type') === 'exam')
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('group_id', TeacherSubjectGroup::find($state)?->group_id);
                    })
                    ->helperText('El grupo se completa automáticamente según la asignación elegida.')
                    ->columnSpanFull(),

                Select::make('group_id')
                    ->label('Grupo')
                    ->relationship(name: 'group', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->prefixIcon('heroicon-o-user-group')
                    ->visible(fn (Get $get) => $get('type') !== 'exam')
                    ->helperText('Opcional. Déjalo vacío si el evento es general para toda la institución.'),

            ]);
    }
}