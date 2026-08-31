<?php

namespace App\Filament\Resources\TaskSubmissions\Schemas;

use App\Models\Student;
use App\Models\Task;
use App\Models\TaskSubmission;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TaskSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('task_id')
                    ->label('Tarea')
                    ->relationship(name: 'task', titleAttribute: 'title')
                    ->getOptionLabelFromRecordUsing(
                        fn (Task $record): string =>
                            "{$record->title} ({$record->teacherSubjectGroup->subject->name} — {$record->teacherSubjectGroup->group->name})"
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-clipboard-document-list')
                    ->afterStateUpdated(fn (callable $set) => $set('student_id', null)),

                Select::make('student_id')
                    ->label('Estudiante')
                    ->options(function (Get $get) {
                        $task = Task::with('teacherSubjectGroup')->find($get('task_id'));

                        if (! $task) {
                            return [];
                        }

                        return Student::with('user')
                            ->whereHas('enrollments', function ($query) use ($task) {
                                $query->where('group_id', $task->teacherSubjectGroup->group_id)
                                    ->where('school_year', now()->year);
                            })
                            ->get()
                            ->mapWithKeys(fn (Student $student) => [
                                $student->id => "{$student->user->name} — {$student->student_code}",
                            ]);
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-user')
                    ->disabled(fn (Get $get) => blank($get('task_id')))
                    ->helperText('Solo se muestran estudiantes matriculados en el grupo de la tarea seleccionada.')
                    ->afterStateUpdated(function ($state, callable $set, Get $get, $livewire) {

                        if (! $state) {
                            return;
                        }

                        $query = TaskSubmission::query()
                            ->where('task_id', $get('task_id'))
                            ->where('student_id', $state);

                        if ($livewire->record) {
                            $query->where('id', '!=', $livewire->record->id);
                        }

                        if ($query->exists()) {
                            Notification::make()
                                ->title('Entrega duplicada')
                                ->body('Este estudiante ya tiene una entrega registrada para esta tarea.')
                                ->danger()
                                ->send();

                            $set('student_id', null);
                        }
                    }),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'submitted' => 'Entregada',
                        'graded' => 'Calificada',
                        'late' => 'Atrasada',
                    ])
                    ->default('pending')
                    ->required()
                    ->native(false),

                DateTimePicker::make('submitted_at')
                    ->label('Fecha de entrega')
                    ->native(false)
                    ->displayFormat('d/m/Y H:i'),

                FileUpload::make('file')
                    ->label('Archivo')
                    ->directory('submissions')
                    ->columnSpanFull(),

                Textarea::make('teacher_feedback')
                    ->label('Retroalimentación del profesor')
                    ->columnSpanFull(),

            ]);
    }
}