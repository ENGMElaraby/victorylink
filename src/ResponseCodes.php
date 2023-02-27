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

    public static function parseResponse(int $response): string
    {
        return match ($response) {
            self::SUCCESS->value => self::SUCCESS->name,
            self::UserIsNotSubscribed->value => self::UserIsNotSubscribed->name,
            self::OutOfCredit->value => self::OutOfCredit->name,
            self::QueuedMessageNoNeedToSendItAgain->value => self::QueuedMessageNoNeedToSendItAgain->name,
            self::InvalidLanguage->value => self::InvalidLanguage->name,
            self::SMSIsEmpty->value => self::SMSIsEmpty->name,
            self::InvalidFakeSenderExceeded12CharsOrEmpty->value => self::InvalidFakeSenderExceeded12CharsOrEmpty->name,
            self::SendingRateGreaterThanReceivingRateOnlyForSendReceiveAccounts->value => self::SendingRateGreaterThanReceivingRateOnlyForSendReceiveAccounts->name,
            self::OtherError->value => self::OtherError->name,
            default => self::FAILED->name
        };
    }

    /**
     * @param int $response
     * @return bool
     */
    public static function isSuccess(int $response): bool
    {
        return self::SUCCESS->value === $response;
    }

    /**
     * @param int $response
     * @return bool
     */
    public static function isFailed(int $response): bool
    {
        return self::FAILED->value !== $response;
    }
}
