<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'holiday' => 'Feriado',
                        'exam' => 'Examen',
                        'meeting' => 'Reunión',
                        'activity' => 'Actividad',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'holiday' => 'gray',
                        'exam' => 'danger',
                        'meeting' => 'info',
                        'activity' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('group.name')
                    ->label('Grupo')
                    ->placeholder('General')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('teacherSubjectGroup.subject.name')
                    ->label('Materia (examen)')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('start')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('end')
                    ->label('Fin')
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
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'holiday' => 'Feriado',
                        'exam' => 'Examen',
                        'meeting' => 'Reunión',
                        'activity' => 'Actividad',
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