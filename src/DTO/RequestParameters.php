<?php

namespace MElaraby\VictoryLink\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class RequestParameters extends DataTransferObject
{
    public string $Username;
    public string $Password;
    public string $SMSText;
    public string $SMSLang;
    public string $SMSReceiver;
    public string $SMSSender;
}
