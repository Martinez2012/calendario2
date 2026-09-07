<?php

namespace App\Filament\Resources\TeacherSubjectGroups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeacherSubjectGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('teacher.user.name')
                    ->label('Profesor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject.name')
                    ->label('Materia')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('group.name')
                    ->label('Grupo (' . now()->year . ')')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Sin asignar' ? 'danger' : 'success'),

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
                //
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