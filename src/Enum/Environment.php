<?php

namespace Docode\Koin\Enum;


class Environment
{
    const SANDBOX       = "SANDBOX";

    const PRODUCTION    = "PRODUCTION";

    public static function getBaseUrl($environment = self::PRODUCTION)
    {
        if ($environment == self::PRODUCTION) {
            return "https://api.koin.com.br/V1/";
        }

        return "http://api.qa.koin.in/V1/";
    }
}