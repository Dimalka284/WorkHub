<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DeliverySubmitted extends Notification
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
            'title' => 'Order Delivered!',
            'message' => 'A delivery has been submitted for your order. Please review it.',
            'order_id' => $this->order->id,
            'action_url' => route('client.orders'),
            'icon' => 'package'
        ];
    }
}
