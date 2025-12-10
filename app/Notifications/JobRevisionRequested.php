<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\JobApplication;

class JobRevisionRequested extends Notification
{
    use Queueable;

    private $application;
    private $revisionMessage;

    public function __construct(JobApplication $application, $revisionMessage = null)
    {
        $this->application = $application;
        $this->revisionMessage = $revisionMessage;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $revisionsUsed = $this->application->revisions_used;
        $maxRevisions = $this->application->max_revisions;
        
        return [
            'title' => 'Revision Requested',
            'message' => "Client requested revision for \"{$this->application->jobPost->title}\" ({$revisionsUsed}/{$maxRevisions} revisions used)",
            'application_id' => $this->application->id,
            'revisions_used' => $revisionsUsed,
            'max_revisions' => $maxRevisions,
            'revision_message' => $this->revisionMessage,
            'action_url' => route('applications.my'),
            'icon' => 'refresh'
        ];
    }
}
