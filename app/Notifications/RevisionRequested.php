<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RevisionRequested extends Notification
{
    use Queueable;

    private $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Revision Requested',
            'message' => 'The client has requested a revision on your delivery.',
            'order_id' => $this->order->id,
            'action_url' => route('freelancer.orders'),
            'icon' => 'refresh'
        ];
    }
}
