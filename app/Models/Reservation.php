<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_id',
        'member_id',
        'book_id',
        'reserved_at',
        'status',
        'fulfilled_at',
    ];  //These are the Reservation fields I'm allowed to save.

    protected $casts = [
        'reserved_at' => 'datetime',
        'fulfilled_at' => 'datetime',
    ]; //casts tells laravel to treat these 2 as dates/times
    
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    } //Each Reservation belongs to one Member, and Laravel should connect reservations.member_id to members.member_id.

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    } //Each Reservation belongs to one Book, connecting reservations.book_id to books.book_id.
}
