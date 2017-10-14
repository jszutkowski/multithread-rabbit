<?php

namespace App\Lib\Rabbit\Config;


class ExchangeFactory
{
    public static function createExampleExchange()
    {
        return new Exchange('example-exchange', ExchangeType::EXCHANGE_TYPE_DIRECT);
    }
}