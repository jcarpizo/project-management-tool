<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\AuditLogResource;
use App\Models\ActivityLog;
use App\Services\AuditLog\AuditLogServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuditLogController extends Controller
{
    private AuditLogServiceInterface $auditLogService;

    public function __construct(AuditLogServiceInterface $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', ActivityLog::class);
        return AuditLogResource::collection($this->auditLogService->getAll());
    }
}
