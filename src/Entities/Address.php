<?php

namespace Docode\Koin\Entities;


class Address extends BaseEntity
{
    protected $fillable = [
        "City",
        "State",
        "Country",
        "District",
        "Street",
        "Number",
        "Complement",
        "ZipCode",
        "AddressType"
    ];
}