<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'image',
        'currency_id',
        'price'
    ];

    public function prices()
    {
        return $this->hasMany(\App\Price::class, 'product_id', 'id');
    }
}
