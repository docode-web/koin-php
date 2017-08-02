<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\StubEntity;

class BaseEntityTest extends TestCase
{
    public function testConvertToJson()
    {
        $stub = new StubEntity([
            "id"    => "123",
            "foo"   => "bar"
        ]);

        $assert = '{"id":"123","foo":"bar"}';

        $this->assertEquals(
            $assert, $stub->toJson()
        );
    }

    public function testConvertObjectsToJson()
    {
        $stub = new StubEntity([
            "id" => "123",
            "foo" => new StubEntity([
                "id" => "456",
                "foo" => new StubEntity([
                    "id" => "789",
                    "foo" => "deu"
                ])
            ])
        ]);

        $assert = '{"id":"123","foo":{"id":"456","foo":{"id":"789","foo":"deu"}}}';

        $this->assertEquals(
            $assert, $stub->toJson()
        );
    }
}