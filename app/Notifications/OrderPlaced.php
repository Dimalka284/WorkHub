<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification
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
            'title' => 'New Order Received',
            'message' => 'You have received a new order! Click to view details.',
            'order_id' => $this->order->id,
            'action_url' => route('freelancer.orders'),
            'icon' => 'shopping-cart'
        ];
    }
}
