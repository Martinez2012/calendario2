<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\TaskSubmission;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskSubmissionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TaskSubmission');
    }

    public function view(AuthUser $authUser, TaskSubmission $taskSubmission): bool
    {
        return $authUser->can('View:TaskSubmission');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TaskSubmission');
    }

    public function update(AuthUser $authUser, TaskSubmission $taskSubmission): bool
    {
        return $authUser->can('Update:TaskSubmission');
    }

    public function delete(AuthUser $authUser, TaskSubmission $taskSubmission): bool
    {
        return $authUser->can('Delete:TaskSubmission');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TaskSubmission');
    }

    public function restore(AuthUser $authUser, TaskSubmission $taskSubmission): bool
    {
        return $authUser->can('Restore:TaskSubmission');
    }

    public function forceDelete(AuthUser $authUser, TaskSubmission $taskSubmission): bool
    {
        return $authUser->can('ForceDelete:TaskSubmission');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TaskSubmission');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TaskSubmission');
    }

    public function replicate(AuthUser $authUser, TaskSubmission $taskSubmission): bool
    {
        return $authUser->can('Replicate:TaskSubmission');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TaskSubmission');
    }

}