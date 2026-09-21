<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeacherResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected ?int $previousUserId = null;

    protected function beforeSave(): void
    {
        // Guarda el user_id anterior antes de que se sobreescriba
        $this->previousUserId = $this->record->getOriginal('user_id');
    }

    protected function afterSave(): void
    {
        $newUserId = $this->record->user_id;

        // Si cambió el usuario, quita el rol al anterior
        if ($this->previousUserId && $this->previousUserId !== $newUserId) {
            $previousUser = \App\Models\User::find($this->previousUserId);
            $previousUser?->removeRole('Profesor');
        }

        // Asigna rol al usuario actual
        $this->record->user->syncRoles(['Profesor']);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}