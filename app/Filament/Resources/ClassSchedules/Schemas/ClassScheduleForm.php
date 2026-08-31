<?php

namespace App\Filament\Resources\ClassSchedules\Schemas;

use App\Models\ClassSchedule;
use App\Models\TeacherSubjectGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ClassScheduleForm
{
    protected static array $dias = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

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
                    ->live()
                    ->prefixIcon('heroicon-o-link')
                    ->columnSpanFull(),

                Select::make('day_of_week')
                    ->label('Día de la semana')
                    ->options(self::$dias)
                    ->required()
                    ->native(false)
                    ->live()
                    ->prefixIcon('heroicon-o-calendar-days'),

                TimePicker::make('start_time')
                    ->label('Hora de inicio')
                    ->native(false)
                    ->seconds(false)
                    ->required()
                    ->live(),

                TimePicker::make('end_time')
                    ->label('Hora de fin')
                    ->native(false)
                    ->seconds(false)
                    ->required()
                    ->after('start_time')
                    ->live()
                    ->afterStateUpdated(
                        fn (callable $get, callable $set, $livewire) =>
                            self::checkOverlap($get, $set, $livewire)
                    ),

            ]);
    }

    /**
     * Evita registrar dos horarios que se crucen para la misma asignación
     * (mismo profesor+materia+grupo) el mismo día.
     */
    protected static function checkOverlap(callable $get, callable $set, $livewire): void
    {
        $assignmentId = $get('teacher_subject_group_id');
        $day = $get('day_of_week');
        $start = $get('start_time');
        $end = $get('end_time');

        if (! $assignmentId || ! $day || ! $start || ! $end) {
            return;
        }

        $query = ClassSchedule::query()
            ->where('teacher_subject_group_id', $assignmentId)
            ->where('day_of_week', $day)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start);

        if ($livewire->record) {
            $query->where('id', '!=', $livewire->record->id);
        }

        if ($query->exists()) {
            Notification::make()
                ->title('Horario cruzado')
                ->body('Ya existe un horario para esta asignación que se cruza con el rango de horas indicado.')
                ->danger()
                ->send();

            $set('end_time', null);
        }
    }
}