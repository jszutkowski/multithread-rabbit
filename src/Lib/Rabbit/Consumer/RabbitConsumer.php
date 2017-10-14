<?php

namespace App\Lib\Rabbit\Consumer;


use App\Lib\Rabbit\Config\Exchange;
use App\Lib\Rabbit\Config\RabbitConnection;

class RabbitConsumer
{
    /**
     * @var RabbitConnection
     */
    private $connection;
    /**
     * @var Exchange
     */
    private $exchange;

    public function __construct(RabbitConnection $connection, Exchange $exchange)
    {
        $this->connection = $connection;
        $this->exchange = $exchange;
    }

    public function listen($routingKey,  $callback)
    {
        $channel = $this->connection->getChannel();
        $channel->exchange_declare($this->exchange->getName(), $this->exchange->getType());
        $channel->basic_qos(null, 10, null);
        list($queueName, ,) = $channel->queue_declare('');
        $channel->queue_bind($queueName, $this->exchange->getName(), $routingKey);
        $channel->basic_consume($queueName, '', false, true, false, false, $callback);

        while (count($channel->callbacks))
        {
            $channel->wait();
        }
    }
}