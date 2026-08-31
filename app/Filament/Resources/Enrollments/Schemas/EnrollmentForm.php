<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use App\Models\Enrollment;
use App\Models\Student;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

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
                    ->live()
                    ->prefixIcon('heroicon-o-user')
                    ->afterStateUpdated(
                        fn (callable $get, callable $set, $livewire) =>
                            self::checkDuplicate($get, $set, $livewire)
                    ),

                Select::make('group_id')
                    ->label('Grupo')
                    ->relationship(name: 'group', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->prefixIcon('heroicon-o-user-group'),

                TextInput::make('school_year')
                    ->label('Año escolar')
                    ->numeric()
                    ->default(now()->year)
                    ->minValue(2000)
                    ->maxValue(2100)
                    ->required()
                    ->live(onBlur: true)
                    ->prefixIcon('heroicon-o-calendar')
                    ->afterStateUpdated(
                        fn (callable $get, callable $set, $livewire) =>
                            self::checkDuplicate($get, $set, $livewire)
                    ),

            ]);
    }

    /**
     * Verifica que el estudiante no tenga ya una matrícula para ese año escolar
     * (evita el error de la restricción unique de la base de datos).
     */
    protected static function checkDuplicate(callable $get, callable $set, $livewire): void
    {
        $studentId = $get('student_id');
        $schoolYear = $get('school_year');

        if (! $studentId || ! $schoolYear) {
            return;
        }

        $query = Enrollment::query()
            ->where('student_id', $studentId)
            ->where('school_year', $schoolYear);

        if ($livewire->record) {
            $query->where('id', '!=', $livewire->record->id);
        }

        if ($query->exists()) {
            Notification::make()
                ->title('Matrícula duplicada')
                ->body('Este estudiante ya tiene una matrícula registrada para ese año escolar.')
                ->danger()
                ->send();

            $set('school_year', null);
        }
    }
}