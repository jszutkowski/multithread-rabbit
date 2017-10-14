<?php

namespace App\Lib\Rabbit\Publisher;


use App\Lib\Rabbit\Config\Exchange;
use App\Lib\Rabbit\Config\RabbitConnection;
use JsonSerializable;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitPublisher
{
    /**
     * @var Exchange
     */

    private $channel;
    private $exchange;

    private $isExchangeDeclared = false;

    public function __construct(RabbitConnection $connection, Exchange $exchange)
    {
        $this->channel = $connection->getChannel();
        $this->exchange = $exchange;
    }

    protected function createUserExchange()
    {
        if (!$this->isExchangeDeclared)
        {
            $this->channel->exchange_declare($this->exchange->getName(), $this->exchange->getType());
            $this->isExchangeDeclared = true;
        }
    }

    public function send(string $routingKey, JsonSerializable $message)
    {
        $this->createUserExchange();
        $this->publish($routingKey, $message);
    }

    protected function publish($routingKey, JsonSerializable $message)
    {
        $amqpMessage = $this->createMessage($message);
        $this->channel->basic_publish($amqpMessage, $this->exchange->getName(), $routingKey);
    }

    protected function createMessage(JsonSerializable $message): AMQPMessage
    {
        return new AMQPMessage(json_encode($message));
    }
}