<?php

namespace Tests;


use Docode\Koin\Entities\Item;
use Docode\Koin\Entities\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testOrderJson()
    {
        $order = new Order();

        $this->assertEquals(
            '{"Currency":"BRL","PaymentType":"21","Buyer":[],"Shipping":[],"Items":[]}',
            $order->toJson()
        );
    }

    public function testOrderItemsToJson()
    {
        $order = new Order();
        $order->addItem(new Item(["foo"=>"bar"]));
        $order->addItem(new Item());
        $this->assertEquals(
            '{"Currency":"BRL","PaymentType":"21","Buyer":[],"Shipping":[],"Items":[{"Attributes":[]},{"Attributes":[]}]}',
            $order->toJson()
        );
    }
}