<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchItem extends Model
{
    use HasFactory;

    protected $fillable = ['dispatch_id', 'item_id', 'quantity', 'unit_price'];

    public function dispatch()
    {
        return $this->belongsTo(Dispatch::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
