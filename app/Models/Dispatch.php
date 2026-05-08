<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    use HasFactory;

    protected $fillable = ['dispatch_number', 'client_id', 'created_by', 'status', 'dispatch_date', 'notes'];

    protected $casts = [
        'dispatch_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dispatchItems()
    {
        return $this->hasMany(DispatchItem::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->dispatchItems->sum(function($item) {
            return $item->quantity * $item->unit_price;
        });
    }
}
