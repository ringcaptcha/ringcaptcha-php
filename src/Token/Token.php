<?php

namespace RingCaptcha\Token;

use DateTime;

class Token
{
    private $value;
    private $expiresAt;
    private $retryAt;

    public function __construct($value, DateTime $expiresAt, DateTime $retryAt)
    {
        $this->value = $value;
        $this->expiresAt = $expiresAt;
        $this->retryAt = $retryAt;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getExpirationDate()
    {
        return $this->expiresAt;
    }

    public function isExpired()
    {
        return $this->expiresAt < new DateTime();
    }
}
