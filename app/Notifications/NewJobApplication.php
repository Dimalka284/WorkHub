<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\JobApplication;

class NewJobApplication extends Notification
{
    use Queueable;

    private $application;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Job Application',
            'message' => 'You have received a new application for your job: ' . $this->application->jobPost->title,
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_post_id,
            'action_url' => route('job.applications', $this->application->job_post_id),
            'icon' => 'briefcase'
        ];
    }
}
