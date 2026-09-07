<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nombre completo')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('student_code')
                    ->label('Código estudiantil')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('current_group')
                    ->label('Grupo (' . now()->year . ')')
                    ->getStateUsing(
                        fn ($record) => $record->enrollments()
                            ->where('school_year', now()->year)
                            ->first()
                            ?->group
                            ?->name ?? 'Sin asignar'
                    )
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Sin asignar' ? 'danger' : 'success'),

                TextColumn::make('user.document')
                    ->label('Documento')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('birth_date')
                    ->label('Fecha de nacimiento')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('guardian_name')
                    ->label('Acudiente')
                    ->searchable(),

                TextColumn::make('guardian_phone')
                    ->label('Teléfono acudiente')
                    ->searchable(),

                TextColumn::make('user.email')
                    ->label('Correo')
                    ->searchable()
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