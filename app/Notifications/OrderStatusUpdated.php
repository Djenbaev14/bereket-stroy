<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // Bildirishnoma qaysi kanallar orqali yuborilishini belgilash
    public function via($notifiable)
    {
        return ['database']; // Ma'lumotlar bazasida saqlanadi
        // Agar email orqali yubormoqchi bo'lsangiz, 'mail' qo'shing: ['database', 'mail']
    }

    // Ma'lumotlar bazasida saqlanadigan bildirishnoma
    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status->name,
            'message' => "Buyurtma #{$this->order->id} holati yangilandi: {$this->order->status->name}",
        ];
    }

    // Agar email orqali yubormoqchi bo'lsangiz (ixtiyoriy)
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Buyurtma holati yangilandi')
            ->line("Buyurtma #{$this->order->id} holati yangilandi.")
            ->line("Yangi holat: {$this->order->status->name}")
            ->action('Buyurtmani ko‘rish', url('/orders/' . $this->order->id))
            ->line('Rahmat!');
    }
}
