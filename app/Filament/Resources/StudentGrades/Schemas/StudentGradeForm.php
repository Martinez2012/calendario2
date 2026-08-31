<?php

namespace App\Filament\Resources\StudentGrades\Schemas;

use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\TaskSubmission;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class StudentGradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('task_submission_id')
                    ->label('Entrega relacionada (opcional)')
                    ->relationship(name: 'taskSubmission', titleAttribute: 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn (TaskSubmission $record): string =>
                            "{$record->student->user->name} — {$record->task->title}"
                    )
                    ->getSearchResultsUsing(
                        fn (string $search) => TaskSubmission::with(['student.user', 'task'])
                            ->whereHas('student.user', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('task', fn ($query) => $query->where('title', 'like', "%{$search}%"))
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn (TaskSubmission $item) => [
                                $item->id => "{$item->student->user->name} — {$item->task->title}",
                            ])
                    )
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-clipboard-document-check')
                    ->helperText('Si eliges una entrega, el estudiante se completa automáticamente.')
                    ->afterStateUpdated(function ($state, callable $set, $livewire) {

                        $submission = TaskSubmission::find($state);
                        $set('student_id', $submission?->student_id);

                        if (! $state) {
                            return;
                        }

                        // Evita dos calificaciones para la misma entrega
                        // (TaskSubmission::grade() es una relación hasOne)
                        $query = StudentGrade::where('task_submission_id', $state);

                        if ($livewire->record) {
                            $query->where('id', '!=', $livewire->record->id);
                        }

                        if ($query->exists()) {
                            Notification::make()
                                ->title('Esta entrega ya tiene una calificación')
                                ->body('Edita la calificación existente en vez de crear otra para la misma entrega.')
                                ->danger()
                                ->send();

                            $set('task_submission_id', null);
                            $set('student_id', null);
                        }
                    })
                    ->columnSpanFull(),

                Select::make('student_id')
                    ->label('Estudiante')
                    ->relationship(name: 'student', titleAttribute: 'student_code')
                    ->getOptionLabelFromRecordUsing(
                        fn (Student $record): string => "{$record->user->name} — {$record->student_code}"
                    )
                    ->getSearchResultsUsing(
                        fn (string $search) => Student::with('user')
                            ->whereHas('user', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                            ->orWhere('student_code', 'like', "%{$search}%")
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn (Student $s) => [$s->id => "{$s->user->name} — {$s->student_code}"])
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->prefixIcon('heroicon-o-user')
                    ->disabled(fn (Get $get) => filled($get('task_submission_id')))
                    ->dehydrated() // el valor debe enviarse aunque el campo esté deshabilitado
                    ->helperText('Se completa solo si elegiste una entrega arriba; si no, selecciónalo manualmente.'),

                TextInput::make('score')
                    ->label('Nota')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->suffixIcon('heroicon-o-star')
                    ->placeholder('Ej. 85.50'),

                Textarea::make('observations')
                    ->label('Observaciones')
                    ->columnSpanFull(),

            ]);
    }
}