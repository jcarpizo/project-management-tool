<?php declare(strict_types=1);

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectDeadlineReminder extends Mailable
{
    use Queueable, SerializesModels;

    public Project $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function build()
    {
        return $this->subject("Reminder: Project '{$this->project->title}' is approaching")
            ->markdown('emails.project.deadline')
            ->with([
                'project' => $this->project,
                'owner' => $this->project->owner,
                'progress' => $this->project->progress,
            ]);
    }
}
