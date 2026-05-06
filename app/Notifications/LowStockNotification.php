<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Item;

class LowStockNotification extends Notification
{
    use Queueable;

    public $item;

    /**
     * Create a new notification instance.
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Low Stock Alert!')
                    ->line('The item ' . $this->item->name . ' has a low stock level (' . $this->item->quantity . ').')
                    ->action('View Item', url('/items/' . $this->item->id))
                    ->line('Please restock it as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'item_id' => $this->item->id,
            'item_name' => $this->item->name,
            'quantity' => $this->item->quantity,
            'message' => 'The item ' . $this->item->name . ' has a low stock level (' . $this->item->quantity . ').',
        ];
    }
}
