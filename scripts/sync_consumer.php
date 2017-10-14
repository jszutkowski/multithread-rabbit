<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Lib\Rabbit\Publisher\Example\ExamplePublisher;
use App\Lib\Rabbit\Config\ExchangeFactory;
use App\Lib\Rabbit\Config\RabbitConnection;
use App\Lib\Rabbit\Consumer\RabbitConsumer;
use PhpAmqpLib\Message\AMQPMessage;


$connection = new RabbitConnection();
$exchange = ExchangeFactory::createExampleExchange();
$consumer = new RabbitConsumer($connection, $exchange);

$consumer->listen(ExamplePublisher::EVENT_SEND_TIMESTAMP, function (AMQPMessage $message) {
    $decodedMessage = json_decode($message->getBody(), true);
    $time = (microtime(true) - $decodedMessage['time']);
    echo $decodedMessage['id'] . ' -> ' . $time . "\n";
});