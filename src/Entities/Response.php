<?php

namespace Docode\Koin\Entities;


class Response
{
    private $status;

    private $code;

    private $message;

    private $additionalInfo;

    private $requestDate;

    private $reference;

    /**
     * Response constructor.
     * @param $response
     */
    public function __construct($response)
    {
        $this->status           = isset($response->Status) ? $response->Status : null;
        $this->code             = isset($response->Code) ? $response->Code : null;
        $this->message          = isset($response->Message) ? $response->Message : null;
        $this->additionalInfo   = isset($response->AdditionalInfo) ? $response->AdditionalInfo : null;
        $this->requestDate      = isset($response->RequestDate) ? $response->Code : null;
        $this->reference        = isset($response->Reference) ? $response->Reference : null;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->code == "200";
    }

    /**
     * @return bool
     */
    public function isUnderAnalysis()
    {
        return $this->code == "312";
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * @return mixed
     */
    public function getRequestDate()
    {
        return $this->requestDate;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }
}