<?php

namespace MElaraby\VictoryLink\Exceptions;


use Exception;

class MethodNotExists extends Exception
{
    /**
     * @param $message
     */
    public function __construct($message = 'Method Not Exists')
    {
        parent::__construct($message);
    }
}
