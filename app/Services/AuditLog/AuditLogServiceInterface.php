<?php declare(strict_types=1);

namespace App\Services\AuditLog;

use Illuminate\Database\Eloquent\Collection;

interface AuditLogServiceInterface
{
    public function getAll(): Collection;
}
