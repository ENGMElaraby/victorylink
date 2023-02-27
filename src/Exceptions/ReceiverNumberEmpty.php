<?php

namespace MElaraby\VictoryLink\Exceptions;


use Exception;

class ReceiverNumberEmpty extends Exception
{
    /**
     * @param $message
     */
    public function __construct($message = 'Receiver Number is Empty')
    {
        parent::__construct($message);
    }
}
