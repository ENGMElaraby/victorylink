<?php

namespace MElaraby\VictoryLink;

enum ResponseCodes: int
{
    case SUCCESS = 0;
    case FAILED = -2;
    case UserIsNotSubscribed = -1;
    case OutOfCredit = -5;
    case QueuedMessageNoNeedToSendItAgain = -10;
    case InvalidLanguage = -11;
    case SMSIsEmpty = -12;
    case InvalidFakeSenderExceeded12CharsOrEmpty = -13;
    case SendingRateGreaterThanReceivingRateOnlyForSendReceiveAccounts = -25;
    case OtherError = -100;
}
