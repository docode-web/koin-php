[![Build Status](https://travis-ci.org/docode-web/koin-php.svg?branch=master)](https://travis-ci.org/docode-web/koin-php)

# Koin PHP
Integração com método de pagamento KOIN

# Instalação
A Instalação deve ser feita via composer:
`composer require docode/koin-php`

### Consulta Crédito e Parcelas
```php
use \Docode\Koin;
use \Docode\Koin\Enum\Environment;
use \Docode\Koin\Entities\Buyer;

$api = new Koin(Environment::SANDBOX, $consumerKey, $secretKey);

$buyer = (new Buyer)
            ->setEmail("foo@bar.baz")
            ->setCpf("47307138000");

$amount = 950.00;

$api->checkCredit($buyer, $amount);
```
Dados Retornados:
http://developers.koin.com.br/ptbr/index.html#consultar-credito


### Gerar Pedidos
```php
use \Docode\Koin;
use \Docode\Koin\Enum\Environment;
use \Docode\Koin\Entities\Buyer;
use \Docode\Koin\Entities\Shipping;
use \Docode\Koin\Entities\Address;

$api = new Koin(Environment::SANDBOX, $consumerKey, $secretKey);

$address = new Address;
$address->setAddressType(AddressType::RESIDENCIAL)
            ->setCity("Porto Alegre")
            ->setDistrict("Centro")
            ->setStreet("Rua Foo Bar")
            ->setNumber("123")
            ->setState("RS")
            ->setZipCode("94000000")
            ->setCountry("Brasil");

$buyer = new Buyer;
$buyer->setName("Foo Bar")
        ->setEmail("foo@bar.baz")
        ->setBirthday("1990-01-01")
        ->setCpf("47307138000")
        ->addPhone("51", "999999999", PhoneType::CELULAR)
        ->setAddress( $address );

$shipping = new Shipping;
$shipping->setAddress( $address )
            ->setPrice(39.90)
            ->setDeliveryDate( new \DateTime );

$item = new Item;
$item->setReference( "123" )
        ->setDescription( "Product Test" )
        ->setPrice( 99.90 )
        ->setQuantity( 2 );

$order = new Order;
$order->setBuyer( $buyer )
        ->setPaymentType( "21" ) // Varia de acordo com a consulta de credito
        ->setShipping( $shipping )
        ->setPrice( 199.80 )
        ->setReference( "ref_order_123" )
        ->setFraudId("dkf348lcu20ecvf8013gfckdksmd");

$order->addItem( $item );

$response = $api->makeOrder( $order );
```
Dados Retornados:
http://developers.koin.com.br/ptbr/index.html#gp-retorno