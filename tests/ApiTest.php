<?php

namespace Tests;


use Docode\Koin\Entities\Address;
use Docode\Koin\Entities\Buyer;
use Docode\Koin\Entities\Item;
use Docode\Koin\Entities\Order;
use Docode\Koin\Entities\Response;
use Docode\Koin\Entities\Shipping;
use Docode\Koin\Enum\AddressType;
use Docode\Koin\Enum\Environment;
use Docode\Koin\Enum\PhoneType;
use Docode\Koin\Koin;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private $consumerKey = "1BFCF567A63E4B6FB38F6A22FFA21FFE";

    private $secretKey = "50856FDA556747A7860C3295C25FEA26";

    public function testCreateOrderApiCall()
    {
        $order = new Order([
            "FraudId" => "dkf348lcu20ecvf8013gfckdksmd"
        ]);

        $api = new Koin(Environment::SANDBOX, $this->consumerKey, $this->secretKey);

        $response = $api->makeOrder( $order );

        $this->assertFalse( $response->isSuccess() );
        $this->assertEquals( 999, $response->getCode() );
    }

    public function testApiCallWithoutKeys()
    {
        $order = new Order([
            "FraudId" => "dkf348lcu20ecvf8013gfckdksmd"
        ]);

        $api = new Koin(Environment::SANDBOX, null, null);

        $response = $api->makeOrder( $order );

        $this->assertFalse( $response->isSuccess() );
        $this->assertEquals( 500, $response->getCode() );
    }

    public function testApiCallCorrectly()
    {
        $order = new Order;
        $buyer = $this->getBuyer();
        $shipping = $this->getShipping();

        $order->setBuyer( $buyer );
        $order->setShipping( $shipping );
        $order->setPrice( 199.90 );
        $order->setReference( md5( microtime() ) );

        $order->setFraudId("dkf348lcu20ecvf8013gfckdksmd");

        $mockApi = $this->getMockBuilder( Koin::class )
                        ->disableOriginalConstructor()
                        ->getMock();

        $mockApi->method("makeOrder")
                ->willReturn(new Response((Object)[
                    "Code" => 300
                ]));

        $order->addItem( $this->getItem(1, "Product Test 1", 19.90, 3) );
        $order->addItem( $this->getItem(2, "Product Test 2", 14.90, 5) );

        $response = $mockApi->makeOrder($order);

        $this->assertEquals("300", $response->getCode());
    }

    /**
     * @return Buyer
     */
    private function getBuyer()
    {
        $buyer = new Buyer();
        $buyer->setName("Foo Bar")
              ->setEmail("foo@bar.baz")
              ->setBirthday("1990-01-01")
              ->setCpf("47307138000")
              ->addPhone("51", "999999999", PhoneType::CELULAR)
              ->setAddress( $this->getAddress() );

        return $buyer;
    }

    /**
     * @return Address $address
     */
    private function getAddress()
    {
        $address = new Address();
        $address->setAddressType(AddressType::RESIDENCIAL)
                ->setCity("Porto Alegre")
                ->setDistrict("Centro")
                ->setStreet("Rua Foo Bar")
                ->setNumber("123")
                ->setState("RS")
                ->setZipCode("94000000")
                ->setCountry("Brasil");

        return $address;
    }

    /**
     * @return Shipping
     */
    private function getShipping()
    {
        $shipping = new Shipping();
        $shipping->setAddress($this->getAddress())
                 ->setPrice(39.90)
                 ->setDeliveryDate( new \DateTime );

        return $shipping;
    }

    /**
     * @param $id
     * @param $name
     * @param $price
     * @param $quantity
     * @return Item
     */
    private function getItem($id, $name, $price, $quantity)
    {
        $item = new Item();
        $item->setReference( $id )
             ->setDescription( $name )
             ->setPrice( $price )
             ->setQuantity( $quantity );

        return $item;
    }
}