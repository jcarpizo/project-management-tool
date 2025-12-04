<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->assignee_id || $user->id === $task->project->owner_id || $user->role === 'admin';
    }

    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->assignee_id || $user->id === $task->project->owner_id || $user->role === 'admin';
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->project->owner_id || $user->role === 'admin';
    }
}
