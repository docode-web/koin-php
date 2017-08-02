<?php

namespace Docode\Koin;


use Docode\Koin\Entities\Order;
use Docode\Koin\Entities\Response;
use Docode\Koin\Enum\Environment;

class Koin
{
    protected $baseUrl;

    private $environment;

    private $consumerKey;

    private $secretKey;

    /**
     * Api constructor.
     * @param $environment
     * @param $consumerKey
     * @param $secretKey
     */
    public function __construct($environment, $consumerKey, $secretKey)
    {
        $this->environment = $environment;
        $this->consumerKey = $consumerKey;
        $this->secretKey = $secretKey;
        $this->baseUrl = Environment::getBaseUrl($environment);
    }

    /**
     * Make a Order
     * @param Order $order
     * @return Response
     */
    public function makeOrder(Order $order)
    {
        return $this->doRequest("TransactionService.svc/Request", $order->toJson());
    }

    /**
     * Dispatch Request to Koin
     * @param $path
     * @param $jsonData
     * @return Response
     */
    private function doRequest($path, $jsonData)
    {
        // Obtém hora do servidor
        $time = time();

        //Criando o hash de autenticação
        $binaryHash = hash_hmac('sha512', $this->baseUrl.$path.$time, $this->secretKey, true);

        //Convertendo para Base64
        $hash = base64_encode($binaryHash);

        //Enviando a requisição
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl.$path);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type:application/json;charset=utf-8",
            "Content-Length:".strlen($jsonData),
            "Authorization: {$this->consumerKey},{$hash},{$time}"
        ]);

        //Recebendo resposta
        try {
            $response = json_decode(curl_exec($ch));
            curl_close ($ch);
            return new Response( $response );
        }
        catch (\Exception $e) {
            return new Response((object)[
                "Code" => 500,
                "Message" => $e->getMessage(),
                "AdditionalInfo" => ["Internal Server Error"]
            ]);
        }
    }
}