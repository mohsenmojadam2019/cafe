<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged extends Notification
{
    protected $status;

    public function __construct($status) {
        $this->status = $status;
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->line('وضعیت سفارش شما به روزرسانی شد.')
            ->line('وضعیت جدید سفارش: ' . $this->status)
            ->action('مشاهده سفارش', url('/orders/' . $notifiable->id))
            ->line('متشکریم که از خدمات ما استفاده می‌کنید!');
    }

    public function toArray($notifiable) {
        return [
            'order_id' => $this->order->id,
            'order_status' => $this->status,
            'customer_name' => $this->order->user->name,
            'customer_email' => $this->order->user->email,
        ];
    }
}
