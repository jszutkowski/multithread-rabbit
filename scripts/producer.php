<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Lib\Rabbit\Publisher\RabbitPublisher;
use App\Lib\Rabbit\Publisher\Example\ExamplePublisher;
use App\Lib\Rabbit\Publisher\Example\Message\ExampleMessage;
use App\Lib\Rabbit\Config\ExchangeFactory;
use App\Lib\Rabbit\Config\RabbitConnection;


$messagesToProduce = 100;

$connection = new RabbitConnection();
$exchange = ExchangeFactory::createExampleExchange();
$publisher = new RabbitPublisher($connection, $exchange);

$message = new ExampleMessage();
for ($i = 1; $i <= $messagesToProduce; $i++)
{
    $message
        ->setId($i)
        ->setTime(microtime(true));

    $publisher->send(ExamplePublisher::EVENT_SEND_TIMESTAMP, $message);
}

echo "Finished sending {$messagesToProduce} messages \n";