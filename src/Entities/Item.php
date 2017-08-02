<?php

namespace Docode\Koin\Entities;


class Item extends BaseEntity
{
    public $fillable = [
        'Reference',
        'Description',
        'Category',
        'Quantity',
        'Price',
        'Attributes'
    ];

    public $attributes = [
        'Attributes' => []
    ];
}