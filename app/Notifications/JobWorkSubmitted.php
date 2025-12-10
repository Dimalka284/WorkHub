<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\JobApplication;

class JobWorkSubmitted extends Notification
{
    use Queueable;

    private $application;
    private $delivery;

    public function __construct(JobApplication $application, $delivery)
    {
        $this->application = $application;
        $this->delivery = $delivery;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Work Submitted',
            'message' => 'Freelancer submitted work for "' . $this->application->jobPost->title . '"',
            'application_id' => $this->application->id,
            'delivery_id' => $this->delivery->id,
            'revision_number' => $this->delivery->revision_number,
            'action_url' => route('job.applications', $this->application->job_post_id),
            'icon' => 'upload'
        ];
    }
}
