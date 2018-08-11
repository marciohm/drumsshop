<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'product_id',
        'currency_id',
        'price'
    ];

    public function currencies()
    {
        return $this->belongsTo(\App\Currency::class, 'currency_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(\App\Product::class, 'product_id', 'id');
    }

}
