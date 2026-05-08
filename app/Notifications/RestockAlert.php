<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestockAlert extends Notification
{
    use Queueable;

    protected $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low Stock Alert: ' . $this->item->name)
            ->greeting('Hello, ' . $notifiable->name)
            ->line('The following item has reached its reorder level:')
            ->line('**Item:** ' . $this->item->name)
            ->line('**SKU:** ' . ($this->item->sku ?? 'N/A'))
            ->line('**Current Quantity:** ' . $this->item->quantity)
            ->line('**Reorder Level:** ' . ($this->item->reorder_level ?? 10))
            ->action('View Item', url('/items/' . $this->item->id))
            ->line('Please consider placing a new purchase order soon.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'item_id' => $this->item->id,
            'item_name' => $this->item->name,
            'quantity' => $this->item->quantity,
            'message' => "Low stock alert for {$this->item->name}. Only {$this->item->quantity} remaining.",
        ];
    }
}
