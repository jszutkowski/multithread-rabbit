<?php

namespace App\Lib\Rabbit\Config;


class ExchangeType
{
    const EXCHANGE_TYPE_FANOUT = 'fanout';
    const EXCHANGE_TYPE_DIRECT = 'direct';
    const EXCHANGE_TYPE_TOPIC = 'topic';
}