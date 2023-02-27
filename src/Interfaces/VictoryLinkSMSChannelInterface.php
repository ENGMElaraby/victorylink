<?php

namespace MElaraby\VictoryLink\Interfaces;

interface VictoryLinkSMSChannelInterface
{
    public function toSMS(mixed $notifiable): array;
}
