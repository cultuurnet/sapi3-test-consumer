<?php

namespace TestConsumer\Credentials;

class Credentials
{
    protected $endPoint;
    protected $key;

    public function getEndPoint()
    {
        return $this->endPoint;
    }

    public function setEndPoint($endPoint)
    {
        $this->endPoint = $endPoint;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }
}
