<?php

namespace Docode\Koin;


use Docode\Koin\Entities\Buyer;
use Docode\Koin\Entities\Order;
use Docode\Koin\Entities\Response;
use Docode\Koin\Enum\Environment;

class Koin
{
    protected $baseUrl;

    protected $restBaseUrl;

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
        $this->restBaseUrl = Environment::getBaseRestUrl($environment);
    }

    /**
     * Make a Order
     * @param Order $order
     * @return Response
     */
    public function makeOrder(Order $order)
    {
        return $this->doRequest("TransactionService.svc/Request", $order->toJson(), false);
    }

    /**
     * Refund Order
     * @param $reference
     * @param $refundType
     * @param $value
     * @param $refundDescription
     * @return Response
     */
    public function refundOrder($reference, $refundType, $value, $refundDescription)
    {
        return $this->doRequest("Transaction/reverse", json_encode([
            "Reference" => $reference,
            "Type"      => $refundType,
            "Value"     => $value,
            "AdditionalInfo" => $refundDescription
        ]), true);
    }

    /**
     * Check Credit is available
     * @param Buyer $buyer
     * @param $creditValue
     * @return Response
     */
    public function checkCredit(Buyer $buyer, $creditValue)
    {
        return $this->doRequest("AccountService.svc/Search", json_encode([
            "Cpf"   => $buyer->getCpf(),
            "Email" => $buyer->Email,
            "Price" => $creditValue
        ]), false);
    }

    /**
     * Check Transaction Status
     * @param $reference
     * @return Response
     */
    public function checkStatus($reference)
    {
        return $this->doRequest("Transaction/status", json_encode([
            "Reference" => $reference
        ]), true);
    }

    /**
     * Inform Tracking Code
     * @param $reference
     * @param $trackingCode
     * @param $carrierCompany
     * @return Response
     */
    public function sendTrackingCode($reference, $trackingCode, $carrierCompany)
    {
        return $this->doRequest("Transaction/delivery", json_encode([
            "Reference"     => $reference,
            "TrackingCode"  => $trackingCode,
            "CarrierCompany"=> $carrierCompany
        ]), true);
    }

    /**
     * Dispatch Request to Koin
     * @param $path
     * @param $jsonData
     * @return Response
     */
    private function doRequest($path, $jsonData, $isRest = true)
    {
        // Obtém hora do servidor
        $time = time();

        $baseUrl = $isRest ? $this->restBaseUrl : $this->baseUrl;

        //Criando o hash de autenticação
        $binaryHash = hash_hmac('sha512', $baseUrl.$path.$time, $this->secretKey, true);

        //Convertendo para Base64
        $hash = base64_encode($binaryHash);

        //Enviando a requisição
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $baseUrl.$path);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type:application/json;charset=utf-8",
            "Content-Length:".strlen($jsonData),
            "Authorization: {$this->consumerKey},{$hash},{$time}"
        ]);

        //Recebendo resposta
        try {
            $curlResponse = curl_exec($ch);
            $jsonResponse = json_decode( $curlResponse );
            $response = new Response( $jsonResponse );

            curl_close ($ch);

            if (!$response->getCode()) {
                throw new \Exception($jsonResponse->message);
            }

            return $response;
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