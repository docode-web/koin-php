<?php

namespace Tests;


use Docode\Koin\Entities\Order;
use Docode\Koin\Enum\Environment;
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
        $this->assertNull( $response->getCode() );
    }
}