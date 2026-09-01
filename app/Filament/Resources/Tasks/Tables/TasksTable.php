<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Models\Student;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): void {

                $user = auth()->user();

                /*
                 * Usuario no autenticado.
                 */
                if (! $user) {
                    $query->whereRaw('1 = 0');

                    return;
                }

                /*
                 * SUPER ADMIN
                 *
                 * Si Shield tiene configurado el método
                 * isSuperAdmin(), dejamos pasar todas las tareas.
                 */
                if (
                    method_exists($user, 'isSuperAdmin')
                    && $user->isSuperAdmin()
                ) {
                    return;
                }

                /*
                 * Buscar el estudiante asociado al usuario.
                 *
                 * students.user_id = users.id
                 */
                $student = Student::query()
                    ->where('user_id', $user->id)
                    ->first();

                /*
                 * Si no es estudiante, por ahora dejamos
                 * todas las tareas visibles.
                 *
                 * Esto permite que profesores/administradores
                 * sigan viendo las tareas.
                 */
                if (! $student) {
                    return;
                }

                /*
                 * Obtener los grupos donde está matriculado
                 * el estudiante.
                 */
                $groupIds = $student->enrollments()
                    ->whereNotNull('group_id')
                    ->pluck('group_id')
                    ->unique()
                    ->values()
                    ->toArray();

                /*
                 * Si el estudiante no tiene grupos,
                 * no debe ver ninguna tarea.
                 */
                if (empty($groupIds)) {
                    $query->whereRaw('1 = 0');

                    return;
                }

                /*
                 * FILTRO:
                 *
                 * Task
                 *   -> teacherSubjectGroup
                 *       -> group_id
                 *
                 * Solo tareas cuyo grupo pertenezca
                 * a uno de los grupos del estudiante.
                 */
                $query->whereHas(
                    'teacherSubjectGroup',
                    function (Builder $teacherSubjectGroupQuery) use ($groupIds): void {
                        $teacherSubjectGroupQuery->whereIn(
                            'group_id',
                            $groupIds
                        );
                    }
                );
            })

            ->columns([
                TextColumn::make('teacherSubjectGroup.teacher.user.name')
                    ->label('Profesor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('teacherSubjectGroup.subject.name')
                    ->label('Materia')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('teacherSubjectGroup.group.name')
                    ->label('Grupo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('assigned_at')
                    ->label('Asignada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('due_at')
                    ->label('Entrega')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
Ñ