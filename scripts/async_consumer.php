<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Lib\Rabbit\Publisher\Example\ExamplePublisher;
use App\Lib\Rabbit\Config\ExchangeFactory;
use App\Lib\Rabbit\Config\RabbitConnection;
use App\Lib\Rabbit\Consumer\RabbitConsumer;
use App\Callback\Async\AsyncConsumerCallback;
use App\Callback\Async\AsyncConsumerCallbackWorker;
use PhpAmqpLib\Message\AMQPMessage;


$connection = new RabbitConnection();
$exchange = ExchangeFactory::createExampleExchange();
$consumer = new RabbitConsumer($connection, $exchange);

$pool = new Pool(100, AsyncConsumerCallbackWorker::class);

$consumer->listen(ExamplePublisher::EVENT_SEND_TIMESTAMP, function (AMQPMessage $message) use ($pool) {

    $pool->submit(new AsyncConsumerCallback($message->getBody()));
});