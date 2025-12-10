<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\JobApplication;

class JobCompleted extends Notification
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
            'title' => 'Job Completed! 🎉',
            'message' => 'Your work for "' . $this->application->jobPost->title . '" has been accepted. Great job!',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_post_id,
            'action_url' => route('applications.my'),
            'icon' => 'check-circle'
        ];
    }
}
