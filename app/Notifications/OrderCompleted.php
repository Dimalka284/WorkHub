<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderCompleted extends Notification
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
            'title' => 'Order Completed',
            'message' => 'Your delivery has been accepted and the order is complete!',
            'order_id' => $this->order->id,
            'action_url' => route('freelancer.orders'),
            'icon' => 'check-double'
        ];
    }
}
