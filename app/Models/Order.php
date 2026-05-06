<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'created_by', 'status', 'order_date', 'expected_delivery', 'notes'];

    protected function casts(): array
    {
        return [
            'order_date' => 'datetime',
            'expected_delivery' => 'datetime',
        ];
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        static::updated(function ($order) {
            if ($order->isDirty('status') && $order->status === 'completed') {
                foreach($order->orderItems as $orderItem) {
                    $qty = $orderItem->quantity_received ?: $orderItem->quantity_ordered;
                    if ($qty > 0) {
                        \App\Models\InventoryTransaction::create([
                            'item_id' => $orderItem->item_id,
                            'user_id' => $order->created_by,
                            'quantity_change' => $qty,
                            'type' => 'IN',
                            'reference' => 'Order ' . $order->order_number,
                        ]);
                    }
                }
            }
        });
    }
}
