<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Project;
use App\Services\Project\ProjectNotificationService;
use Illuminate\Console\Command;

class SendProjectDeadlineReminders extends Command
{
    protected $signature = 'projects:send-deadline-reminders {--days=1}';
    protected $description = 'Send email reminders for upcoming project deadlines';

    public function handle()
    {
        $days = $this->option('days');
        $projects = Project::upcomingDeadline($days)->with('owner')->get();

        foreach ($projects as $project) {
            ProjectNotificationService::sendDeadlineReminder($project);
        }

        $this->info("Deadline reminders sent for {$projects->count()} project(s).");
    }
}
