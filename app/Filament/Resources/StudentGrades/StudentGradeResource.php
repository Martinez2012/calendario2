<?php

  namespace App\Filament\Resources\StudentGrades;

  use App\Filament\Resources\StudentGrades\Pages\CreateStudentGrade;
  use App\Filament\Resources\StudentGrades\Pages\EditStudentGrade;
  use App\Filament\Resources\StudentGrades\Pages\ListStudentGrades;
  use App\Filament\Resources\StudentGrades\Schemas\StudentGradeForm;
  use App\Filament\Resources\StudentGrades\Tables\StudentGradesTable;
  use App\Models\StudentGrade;
  use BackedEnum;
  use Filament\Resources\Resource;
  use Filament\Schemas\Schema;
  use Filament\Support\Icons\Heroicon;
  use Filament\Tables\Table;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Support\Facades\Auth;

  class StudentGradeResource extends Resource
  {
      protected static ?string $model = StudentGrade::class;

      protected static string|BackedEnum|null $navigationIcon =
  Heroicon::OutlinedChartBar;

      protected static ?string $recordTitleAttribute =
  'calificacion_del_estudiante';

      protected static ?string $navigationLabel =
  'Calificaciones de Estudiantes';

      protected static ?string $modelLabel = 'Calificación de
  Estudiante';

      protected static ?string $pluralModelLabel =
  'Calificaciones de Estudiantes';

      /*** Implementación del filtrado de seguridad para discriminación de notas* según el rol y grupo del usuario autenticado.*/
      public static function getEloquentQuery(): Builder
      {
          $user = Auth::user();
          $query = parent::getEloquentQuery();

          if (!$user) {
              return $query;
          }

          // 1. El Estudiante: Solo puede ver sus propiascalificaciones
          if ($user->hasRole('student')) {
              return $query->where('student_id',
  $user->student->id);
          }

          // 2. El Profesor: Solo ve calificaciones de alumnos que pertenecen a sus grupos asignados 
          // Ruta: StudentGrade -> Student -> Enrollments -> Group -> TeacherSubjectGroup -> Teacher
          if ($user->hasRole('teacher')) {
              return $query->whereHas('student.enrollments',
  function ($q) use ($user) {
                  $q->whereHas('group.teacherSubjectGroups',
  function ($groupQuery) use ($user) {
                      $groupQuery->where('teacher_id',
  $user->teacher->id);
                  });
              });
          }

          // 3. Administradores: Acceso total a todas las calificaciones
          return $query;
      }

      public static function form(Schema $schema): Schema
      {
          return StudentGradeForm::configure($schema);
      }

      public static function table(Table $table): Table
      {
          return StudentGradesTable::configure($table);
      }

      public static function getRelations(): array
      {
          return [
              //
          ];
      }

      public static function getPages(): array
      {
          return [
              'index' => ListStudentGrades::route('/'),
              'create' => CreateStudentGrade::route('/create'),
              'edit' =>
  EditStudentGrade::route('/{record}/edit'),
          ];
      }
  }