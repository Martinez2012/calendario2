<?php

namespace App\Filament\Resources\TeacherSubjectGroups\Pages;

use App\Filament\Resources\TeacherSubjectGroups\TeacherSubjectGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeacherSubjectGroup extends EditRecord
{
    protected static string $resource = TeacherSubjectGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
