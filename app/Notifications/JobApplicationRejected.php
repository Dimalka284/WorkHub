<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\JobApplication;

class JobApplicationRejected extends Notification
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
            'title' => 'Application Update',
            'message' => 'Your application for "' . $this->application->jobPost->title . '" was not selected.',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_post_id,
            'action_url' => route('applications.my'),
            'icon' => 'x-circle'
        ];
    }
}
