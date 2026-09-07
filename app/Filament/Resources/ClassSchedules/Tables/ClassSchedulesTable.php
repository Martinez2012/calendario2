<?php

namespace App\Filament\Resources\ClassSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClassSchedulesTable
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

    public static function configure(Table $table): Table
    {
        return $table
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
                    ->label('Grupo (' . now()->year . ')')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Sin asignar' ? 'danger' : 'success'),

                TextColumn::make('day_of_week')
                    ->label('Día')
                    ->formatStateUsing(fn (int $state): string => self::$dias[$state] ?? $state)
                    ->badge()
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Inicio')
                    ->time('H:i')
                    ->sortable(),

                TextColumn::make('end_time')
                    ->label('Fin')
                    ->time('H:i')
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
            ->filters([
                SelectFilter::make('day_of_week')
                    ->label('Día')
                    ->options(self::$dias),
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