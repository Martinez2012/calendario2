<?php

namespace App\Filament\Resources\Enrollments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.user.name')
                    ->label('Estudiante')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('student.student_code')
                    ->label('Código')
                    ->searchable()
                    ->toggleable(),
                
                TextColumn::make('group.name')
                    ->label('Grupo (' . now()->year . ')')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Sin asignar' ? 'danger' : 'success'),

                TextColumn::make('school_year')
                    ->label('Año escolar')
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
                SelectFilter::make('school_year')
                    ->label('Año escolar')
                    ->options(fn () => \App\Models\Enrollment::query()
                        ->distinct()
                        ->orderByDesc('school_year')
                        ->pluck('school_year', 'school_year')
                        ->toArray()
                    ),
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