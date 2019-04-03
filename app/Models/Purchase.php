<?php

namespace App\Models;


class Purchase
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_product',
    ];
}
