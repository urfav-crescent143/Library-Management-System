<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; //without this import the php doesnt know what to belongs to ...
use Illuminate\Database\Eloquent\Relations\HasMany;  //Has many connection : connection with borrowings and reservations
class Book extends Model
{
    protected $fillable = [ 
        'book_id', 
        'title', 
        'author_id', 
        'category_id', 
        'total_copies', 
        'available_copies', 
    ];
    public function author(): BelongsTo { 
        return $this->belongsTo( 
            Author::class, 
            'author_id', 
            'author_id' 
        ); 
    }
    public function category(): BelongsTo { 
        return $this->belongsTo( 
            Category::class, 
            'category_id', 
            'id' 
        ); 
    }

    //For Borrowings
    public function borrowings(): HasMany  //one book can have many borrowings
    {
        return $this->hasMany(Borrowing::class);
    }

    //For Reservations
    public function reservations(): HasMany  //One book can have many reservations over time.
    {
        return $this->hasMany(Reservation::class, 'book_id', 'book_id');
    }
}
