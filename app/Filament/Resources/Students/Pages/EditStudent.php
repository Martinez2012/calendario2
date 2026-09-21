<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected ?int $previousUserId = null;

    protected function beforeSave(): void
    {
        $this->previousUserId = $this->record->getOriginal('user_id');
    }

    protected function afterSave(): void
    {
        $newUserId = $this->record->user_id;

        // Si cambió el usuario, quita el rol al anterior
        if ($this->previousUserId && $this->previousUserId !== $newUserId) {
            $previousUser = \App\Models\User::find($this->previousUserId);
            $previousUser?->removeRole('Alumno');
        }

        // Asigna rol al usuario actual
        $this->record->user->syncRoles(['Alumno']);

        // Matrícula
        $this->record->enrollments()->updateOrCreate(
            ['school_year' => now()->year],
            ['group_id' => $this->data['group_id']]
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}