<?php
namespace App\Callback\Async;


use Thread;

class AsyncConsumerCallback extends Thread
{

    /**
     * @var string
     */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function run()
    {
        $decodedMessage = json_decode($this->message, 1);
        $time = (microtime(true) - $decodedMessage['time']);
        $memory = (memory_get_usage(true) / 1024 / 1024);
        echo "{$decodedMessage['id']}, {$time}, {$memory}MB \n";
//        sleep(3);
//        echo "Action {$decodedMessage['id']} \n";
    }
}