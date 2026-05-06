<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'user_id', 'quantity_change', 'type', 'reference', 'transaction_date'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($transaction) {
            $item = $transaction->item;
            $change = abs($transaction->quantity_change);
            if ($transaction->type === 'IN' || $transaction->type === 'ADJUSTMENT' && $transaction->quantity_change > 0) {
                $item->increment('quantity', $change);
            } else if ($transaction->type === 'OUT' || $transaction->type === 'ADJUSTMENT' && $transaction->quantity_change < 0) {
                $item->decrement('quantity', $change);
            }
            
            // Reload item to get fresh quantity
            $item->refresh();

            if ($item->quantity < 5) {
                $admins = User::where('role', 'admin')->get();
                foreach($admins as $admin) {
                     $admin->notify(new \App\Notifications\LowStockNotification($item));
                }
            }
        });

        static::deleted(function ($transaction) {
            $item = $transaction->item;
            $change = abs($transaction->quantity_change);
            if ($transaction->type === 'IN' || $transaction->type === 'ADJUSTMENT' && $transaction->quantity_change > 0) {
                $item->decrement('quantity', $change);
            } else if ($transaction->type === 'OUT' || $transaction->type === 'ADJUSTMENT' && $transaction->quantity_change < 0) {
                $item->increment('quantity', $change);
            }
        });
    }
}
