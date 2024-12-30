<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    //
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    protected function image(): Attribute
{
    return Attribute::make(
        get: fn ($value) => url('/storage/categories/' . $value),
    );
}

}
