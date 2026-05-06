<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'generated_date', 'parameters', 'file_path', 'generated_by'];

    protected function casts(): array
    {
        return [
            'parameters' => 'array',
            'generated_date' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
