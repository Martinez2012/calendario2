<?php

namespace App\Filament\Resources\TaskSubmissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TaskSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('task.title')
                    ->label('Tarea')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('task.teacherSubjectGroup.group.name')
                    ->label('Grupo')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('student.user.name')
                    ->label('Estudiante')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'submitted' => 'Entregada',
                        'graded' => 'Calificada',
                        'late' => 'Atrasada',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'submitted' => 'info',
                        'graded' => 'success',
                        'late' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('submitted_at')
                    ->label('Fecha de entrega')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Sin entregar'),

                TextColumn::make('file')
                    ->label('Archivo')
                    ->placeholder('Sin archivo')
                    ->limit(30)
                    ->toggleable(),

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
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'submitted' => 'Entregada',
                        'graded' => 'Calificada',
                        'late' => 'Atrasada',
                    ]),
            ])
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