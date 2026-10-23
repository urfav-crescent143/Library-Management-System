<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Borrowing; //fine belongs to borrowing

class Fine extends Model
{
    protected $fillable = [
        'borrowing_id',
        'overdue_days',
        'amount',
        'status',
        'paid_at',
    ];
    protected $casts = [
    'paid_at' => 'datetime',
    ];

    public function borrowing(): BelongsTo //one fine belongs to one borrowing
    {
        return $this->belongsTo(Borrowing::class);
    }
}