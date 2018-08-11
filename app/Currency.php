<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'currency',
        'symbol'
    ];

    public static $rules = [
        'currency' => 'required|min:2',
        'symbol' => 'required|min:1'
    ];

}
