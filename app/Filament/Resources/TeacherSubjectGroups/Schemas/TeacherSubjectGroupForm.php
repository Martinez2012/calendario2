<?php

namespace App\Filament\Resources\TeacherSubjectGroups\Schemas;

use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubjectGroup;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;

class TeacherSubjectGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('teacher_id')
                    ->label('Profesor')
                    ->relationship(name: 'teacher', titleAttribute: 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn (Teacher $record): string => $record->user->name
                    )
                    ->searchable(['specialty'])
                    ->getSearchResultsUsing(
                        fn (string $search) => Teacher::whereHas(
                            'user',
                            fn ($query) => $query->where('name', 'like', "%{$search}%")
                        )->limit(50)->get()->mapWithKeys(
                            fn (Teacher $teacher) => [$teacher->id => $teacher->user->name]
                        )
                    )
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-user')
                    ->afterStateUpdated(
                        fn ($state, callable $get, callable $set, $livewire) =>
                            self::checkDuplicate($get, $set, $livewire)
                    ),

                Select::make('subject_id')
                    ->label('Materia')
                    ->relationship(name: 'subject', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-book-open')
                    ->afterStateUpdated(
                        fn ($state, callable $get, callable $set, $livewire) =>
                            self::checkDuplicate($get, $set, $livewire)
                    ),

                Select::make('group_id')
                    ->label('Grupo')
                    ->relationship(name: 'group', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-user-group')
                    ->afterStateUpdated(
                        fn ($state, callable $get, callable $set, $livewire) =>
                            self::checkDuplicate($get, $set, $livewire)
                    ),

            ]);
    }

    /**
     * Verifica si la combinación profesor+materia+grupo ya existe
     * (evita el error de la restricción unique de la base de datos).
     */
    protected static function checkDuplicate(callable $get, callable $set, $livewire): void
    {
        $teacherId = $get('teacher_id');
        $subjectId = $get('subject_id');
        $groupId = $get('group_id');

        if (! $teacherId || ! $subjectId || ! $groupId) {
            return;
        }

        $query = TeacherSubjectGroup::query()
            ->where('teacher_id', $teacherId)
            ->where('subject_id', $subjectId)
            ->where('group_id', $groupId);

        if ($livewire->record) {
            $query->where('id', '!=', $livewire->record->id);
        }

        if ($query->exists()) {
            Notification::make()
                ->title('Asignación duplicada')
                ->body('Este profesor ya tiene asignada esta materia en este grupo.')
                ->danger()
                ->send();

            $set('group_id', null);
        }
    }
}