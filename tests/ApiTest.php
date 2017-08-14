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
    private $consumerKey = "61D7DAE70ED6496EB7EDDE5FE0D15B47";

    private $secretKey = "50856FDA556747A7860C3295C25FEA26";

    public function testCreateOrderApiCall()
    {
        $order = new Order([
            "FraudId" => "dkf348lcu20ecvf8013gfckdksmd",
            "PaymentType" => "21"
        ]);

        $api = new Koin(Environment::SANDBOX, $this->consumerKey, $this->secretKey);

        $response = $api->makeOrder( $order );

        $this->assertFalse( $response->isSuccess() );
        $this->assertEquals( 501, $response->getCode() );
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

        $api = $this->getMockApi();

        $api->method("makeOrder")
                ->willReturn(new Response((Object)[
                    "Code" => 300
                ]));

        $order->addItem( $this->getItem(1, "Product Test 1", 19.90, 3) );
        $order->addItem( $this->getItem(2, "Product Test 2", 14.90, 5) );

        $response = $api->makeOrder($order);

        $this->assertEquals("300", $response->getCode());
    }

    public function testCheckCreditLimit()
    {
        $buyer = $this->getBuyer();

        $api = $this->getMockApi();

        $api->method("checkCredit")
            ->willReturn(new Response((Object)[
                "Code" => 10100,
                "CreditLimitAvailable"=> 1000.00,
	            "Message"=> "Consulta realizada com sucesso.",
                "installmentOptions"=> [
                    (Object)[
                    "iof"=> "0",
                    "cet"=> "0",
                    "installments"=> "1",
                    "rates"=> "0",
                    "description"=> "A Vista",
                    "originalValue"=> "500.00",
                    "firstDueDate"=> "2017-08-10",
                    "orderValue"=> "500.00",
                    "installmentValue"=> "500.00",
                    "paymentType"=> "21"
                ], (Object) [
                    "iof"=> "2.61",
                    "cet"=> "312.13",
                    "installments"=> "2",
                    "rates"=> "11.90",
                    "description"=> "2 x de R$295.28",
                    "originalValue"=> "500.00",
                    "firstDueDate"=> "2017-08-10",
                    "orderValue"=> "590.56",
                    "installmentValue"=> "295.28",
                    "paymentType"=> "22"
                ]]
            ]));

        /**
         * @var Response $response
         */
        $response = $api->checkCredit($buyer, 200);

        $this->assertEquals(10100, $response->getCode());
        $this->assertEquals(1000.00, $response->getCreditLimitAvailable() );
        $this->assertCount(2, $response->getInstallmentOptions() );
    }

    public function testCheckTransactionStatus()
    {
        $api = $this->getMockApi();

        $api->method("checkStatus")
            ->willReturn(new Response((Object)[
                    "Status"=>"Aprovado",
                    "Code"=>200,
                    "Message"=>"Sua compra foi APROVADA! Obrigado por comprar com Koin Pós-Pago.",
                    "RequestDate"=>"2014-08-06 12:14:44",
                    "AdditionalInfo"=> null,
                    "Reference"=>"11919"
            ]));

        /**
         * @var Response $response
         */
        $response = $api->checkStatus("11919");

        $this->assertEquals(200, $response->getCode());
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockApi()
    {
        $api = $this->getMockBuilder( Koin::class )
            ->disableOriginalConstructor()
            ->getMock();

        return $api;
    }
}