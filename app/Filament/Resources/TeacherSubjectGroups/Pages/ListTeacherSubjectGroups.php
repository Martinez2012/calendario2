<?php

namespace App\Filament\Resources\TeacherSubjectGroups\Pages;

use App\Filament\Resources\TeacherSubjectGroups\TeacherSubjectGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeacherSubjectGroups extends ListRecords
{
    protected static string $resource = TeacherSubjectGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
