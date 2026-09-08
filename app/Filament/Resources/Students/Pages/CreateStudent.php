<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function afterCreate(): void
    {
        $this->record->enrollments()->create([
            'group_id' => $this->data['group_id'],
            'school_year' => now()->year,
        ]);

        $this->record->user->syncRoles(['alumno']);
    }
}