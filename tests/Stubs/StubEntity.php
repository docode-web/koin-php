<?php

namespace Tests\Stubs;


use Docode\Koin\Entities\BaseEntity;

class StubEntity extends BaseEntity
{
    public $fillable = [
        "id",
        "foo"
    ];
}