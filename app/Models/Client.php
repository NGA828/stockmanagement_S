<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'contact_person', 'email', 'phone', 'address'];

    public function dispatches()
    {
        return $this->hasMany(Dispatch::class);
    }
}
