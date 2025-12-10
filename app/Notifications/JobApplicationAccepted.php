<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\JobApplication;

class JobApplicationAccepted extends Notification
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
            'title' => 'Application Accepted!',
            'message' => 'Your application for "' . $this->application->jobPost->title . '" has been accepted.',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_post_id,
            'action_url' => route('applications.my'), 
            'icon' => 'check-circle'
        ];
    }
}
