<?php

namespace App\Lib\Rabbit\Publisher\Example\Message;

class ExampleMessage implements \JsonSerializable
{
    private $id;
    private $time;

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function setTime(int $time)
    {
        $this->time = $time;
        return $this;
    }

    function jsonSerialize()
    {
        return ['id' => $this->id, 'time' => $this->time];
    }
}