<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;  //Has many connection :connection with borrowings and reservations

class Member extends Model
{
    protected $fillable = [
        'member_id',
        'member_name',
        'email',
        'phone',
        'join_date',
        'status',
    ];

    public function borrowings(): HasMany  //A member can have many borrowing records.
    {
        return $this->hasMany(Borrowing::class);
    }

    //for reservations
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'member_id', 'member_id'); //One member can have many reservations.
    }

    //For the date to works we need to add
    protected function casts(): array
    {
        return [
            'join_date' => 'date',
        ];
    }
}
