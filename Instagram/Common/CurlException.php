<?php
namespace Instagram\Common;

class CurlException
{
    public function __construct($message)
    {
        if (gettype($message) !== 'string') {
            $message = json_encode($message);
        }

        throw new \Exception($message);
    }
}