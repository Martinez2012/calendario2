<?php

  namespace App\Filament\Resources\Tasks;

  use App\Filament\Resources\Tasks\Pages\CreateTask;
  use App\Filament\Resources\Tasks\Pages\EditTask;
  use App\Filament\Resources\Tasks\Pages\ListTasks;
  use App\Filament\Resources\Tasks\Schemas\TaskForm;
  use App\Filament\Resources\Tasks\Tables\TasksTable;
  use App\Models\Task;
  use BackedEnum;
  use Filament\Resources\Resource;
  use Filament\Schemas\Schema;
  use Filament\Support\Icons\Heroicon;
  use Filament\Tables\Table;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Support\Facades\Auth;

  class TaskResource extends Resource
  {
      protected static ?string $model = Task::class;

      protected static string|BackedEnum|null $navigationIcon =
  Heroicon::OutlinedClipboardDocumentList;

      protected static ?string $recordTitleAttribute = 'tarea';

      protected static ?string $navigationLabel = 'Tareas';

      protected static ?string $modelLabel = 'Tarea';

      protected static ?string $pluralModelLabel = 'Tareas';

      /**
       * Sobrescribimos la consulta base para discriminar las
  tareas
       * según el rol y grupo del usuario autenticado.
       */
      public static function getEloquentQuery(): Builder
      {
          $user = Auth::user();
          $query = parent::getEloquentQuery();

          if (!$user) {
              return $query;
          }

          if ($user->hasRole('student')) {
              return $query->whereHas('teacherSubjectGroup',
  function ($q) use ($user) {
                  $q->whereHas('group', function ($groupQuery)
  use ($user) {
                      $groupQuery->whereIn('id', function
  ($enrollmentQuery) use ($user) {
                          $enrollmentQuery->select('group_id')
                              ->from('enrollments')
                              ->where('student_id',
  $user->student->id);
                      });
                  });
              });
          }

          if ($user->hasRole('teacher')) {
              return $query->whereHas('teacherSubjectGroup',
  function ($q) use ($user) {
                  $q->where('teacher_id', $user->teacher->id);
              });
          }

          return $query;
      }

      public static function form(Schema $schema): Schema
      {
          return TaskForm::configure($schema);
      }

      public static function table(Table $table): Table
      {
          return TasksTable::configure($table);
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
              'index' => ListTasks::route('/'),
              'create' => CreateTask::route('/create'),
              'edit' => EditTask::route('/{record}/edit'),
          ];
      }
  }