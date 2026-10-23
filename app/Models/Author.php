<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
        'author_id',
        'author_name',
        'nationality',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'author_id', 'author_id');
    }
}