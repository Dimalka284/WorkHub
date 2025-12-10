<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderRejected extends Notification
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
            'title' => 'Order Rejected',
            'message' => 'Unfortunately, your order request was rejected.',
            'order_id' => $this->order->id,
            'action_url' => route('client.orders'),
            'icon' => 'x-circle'
        ];
    }
}
