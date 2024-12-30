<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BookImage extends Model
{
    //
    protected $fillable = [
        'book_id',
        'image',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected function image(): Attribute
{
    return Attribute::make(
        get: fn ($value) => url('/storage/books/' . $value),
    );
}
}
