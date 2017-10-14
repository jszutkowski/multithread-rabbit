<?php

namespace App\Lib\Rabbit\Config;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitConnection
{
    /**
     * @var AMQPStreamConnection
     */
    protected $connection;

    /**
     * @return AMQPChannel
     */
    protected $channel;

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        if (!$this->channel)
        {
            $this->createConnection();
        }

        return $this->channel;
    }

    protected function createConnection()
    {
        $this->connection = new AMQPStreamConnection('172.21.0.1', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}