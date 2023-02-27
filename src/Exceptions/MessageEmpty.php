<?php

namespace MElaraby\VictoryLink\Exceptions;


use Exception;

class MessageEmpty extends Exception
{
    /**
     * @param $message
     */
    public function __construct($message = 'Message is Empty')
    {
        parent::__construct($message);
    }
}
