<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TeacherSubjectGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherSubjectGroupPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TeacherSubjectGroup');
    }

    public function view(AuthUser $authUser, TeacherSubjectGroup $teacherSubjectGroup): bool
    {
        return $authUser->can('View:TeacherSubjectGroup');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TeacherSubjectGroup');
    }

    public function update(AuthUser $authUser, TeacherSubjectGroup $teacherSubjectGroup): bool
    {
        return $authUser->can('Update:TeacherSubjectGroup');
    }

    public function delete(AuthUser $authUser, TeacherSubjectGroup $teacherSubjectGroup): bool
    {
        return $authUser->can('Delete:TeacherSubjectGroup');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TeacherSubjectGroup');
    }

    public function restore(AuthUser $authUser, TeacherSubjectGroup $teacherSubjectGroup): bool
    {
        return $authUser->can('Restore:TeacherSubjectGroup');
    }

    public function forceDelete(AuthUser $authUser, TeacherSubjectGroup $teacherSubjectGroup): bool
    {
        return $authUser->can('ForceDelete:TeacherSubjectGroup');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TeacherSubjectGroup');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TeacherSubjectGroup');
    }

    public function replicate(AuthUser $authUser, TeacherSubjectGroup $teacherSubjectGroup): bool
    {
        return $authUser->can('Replicate:TeacherSubjectGroup');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TeacherSubjectGroup');
    }

}