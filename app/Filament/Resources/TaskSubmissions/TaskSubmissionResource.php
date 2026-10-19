<?php

  namespace App\Filament\Resources\TaskSubmissions;

  use App\Filament\Resources\TaskSubmissions\Pages\CreateTaskSubmission;
  use App\Filament\Resources\TaskSubmissions\Pages\EditTaskSubmission;
  use App\Filament\Resources\TaskSubmissions\Pages\ListTaskSubmissions;
  use App\Filament\Resources\TaskSubmissions\Schemas\TaskSubmissionForm;
  use App\Filament\Resources\TaskSubmissions\Tables\TaskSubmissionsTable;
  use App\Models\TaskSubmission;
  use BackedEnum;
  use Filament\Resources\Resource;
  use Filament\Schemas\Schema;
  use Filament\Support\Icons\Heroicon;
  use Filament\Tables\Table;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Support\Facades\Auth;

  class TaskSubmissionResource extends Resource
  {
      protected static ?string $model = TaskSubmission::class;

      protected static string|BackedEnum|null $navigationIcon =
  Heroicon::OutlinedDocumentArrowUp;

      protected static ?string $recordTitleAttribute =
  'envio_de_la_tarea';

      protected static ?string $navigationLabel = 'Entregas de
  Tareas';

      protected static ?string $modelLabel = 'Entrega de Tarea';

      protected static ?string $pluralModelLabel = 'Entregas de
  Tareas';

      /*** Implementación del filtrado de seguridad para discriminar entregas * según el rol del usuario autenticado. */
      public static function getEloquentQuery(): Builder
      {
          $user = Auth::user();
          $query = parent::getEloquentQuery();

          if (!$user) {
              return $query;
          }

          // 1. El Alumno: Solo puede ver sus propias entregas personales
          if ($user->hasRole('student')) {
              return $query->where('student_id',
  $user->student->id);
          }

          // 2. El Docente: Solo ve entregas de tareas que él mismo publicó 
           // Relación: TaskSubmission -> Task -> TeacherSubjectGroup -> Teacher
          if ($user->hasRole('teacher')) {
              return
  $query->whereHas('task.teacherSubjectGroup', function ($q) use
  ($user) {
                  $q->where('teacher_id', $user->teacher->id);
              });
          }

          // 3. Super Admin: Tiene acceso total a todas las entregas
          return $query;
      }

      public static function form(Schema $schema): Schema
      {
          return TaskSubmissionForm::configure($schema);
      }

      public static function table(Table $table): Table
      {
          return TaskSubmissionsTable::configure($table);
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
              'index' => ListTaskSubmissions::route('/'),
              'create' =>
  CreateTaskSubmission::route('/create'),
              'edit' =>
  EditTaskSubmission::route('/{record}/edit'),
          ];
      }
  }