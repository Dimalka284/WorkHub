<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderAccepted extends Notification
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
            'title' => 'Order Accepted',
            'message' => 'Your order has been accepted and is now in progress.',
            'order_id' => $this->order->id,
            'action_url' => route('client.orders'),
            'icon' => 'check-circle'
        ];
    }
}
