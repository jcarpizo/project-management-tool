<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\ActivityLog;

class ActivityLogPolicy
{
    /**
     * Determine if the user can view any activity logs.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can view a specific activity log.
     */
    public function view(User $user, ActivityLog $log): bool
    {
        return $user->role === 'admin';
    }

    // Optionally add create, update, delete if needed
}
