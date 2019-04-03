<?php

namespace App\Models;


class Product
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_product', 'category', 'value', 'description'
    ];
}
