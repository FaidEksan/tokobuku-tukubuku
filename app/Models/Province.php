<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $fillable = [
        'name',
    ];


    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
