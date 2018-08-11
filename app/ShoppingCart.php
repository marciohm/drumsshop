<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'currency_id',
        'price',
        'quantity',
        'total'
    ];

    public function currencies()
    {
        return $this->belongsTo(\App\Currency::class, 'currency_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(\App\Product::class, 'product_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

}
