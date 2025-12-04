<?php declare(strict_types=1);

namespace App\Services\AuditLog;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Collection;

class AuditLogService implements AuditLogServiceInterface
{
    public function getAll(): Collection
    {
        return ActivityLog::all();
    }
}
