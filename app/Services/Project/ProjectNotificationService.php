<?php declare(strict_types=1);

namespace App\Services\Project;

use App\Mail\ProjectDeadlineReminder;
use App\Models\Project;
use Illuminate\Support\Facades\Mail;

class ProjectNotificationService
{
    public static function sendDeadlineReminder(Project $project)
    {
        Mail::to($project->owner->email)->queue(new ProjectDeadlineReminder($project));
    }
}
