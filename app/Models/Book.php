<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'price',
        'description',
    ];

        public function category()
        {
            return $this->belongsTo(Category::class);
        }

        public function images()
        {
            return $this->hasMany(BookImage::class);
        }

        public function carts()
        {
            return $this->hasMany(Cart::class);
        }

        public function transactionDetails()
        {
            return $this->hasMany(TransactionDetail::class);
        }
}
