<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// For connecting to fine
use App\Models\Fine;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Borrowing extends Model
{
    protected $fillable = [
        'borrowing_id',
        'member_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
    ];
    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'datetime',
    ]; // So Laravel can understand the date calculations in ReturnController(line 31 & 32)

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function getStatusAttribute()
    {
        if ($this->returned_at) {
            return 'Returned';
        }

        if (now()->startOfDay()->gt(\Carbon\Carbon::parse($this->due_date)->startOfDay())) {
            return 'Overdue';
        }

        return 'Borrowed';
    }
    //For 
    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }
}