<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ActivityObserver
{
    public function created($model)
    {
        $this->logActivity($model, 'created');
    }

    public function updated($model)
    {
        $this->logActivity($model, 'updated', $model->getChanges());
    }

    public function deleted($model)
    {
        $this->logActivity($model, 'deleted');
    }

    protected function logActivity($model, string $action, array $changes = null)
    {
        ActivityLog::create([
            'id' => Str::uuid(),
            'user_id' => Auth::id() ?? $model->owner_id ?? null,
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            'action' => $action,
            'changes' => $changes ? json_encode($changes) : null,
        ]);
    }
}
