<?php

namespace RingCaptcha;

use RingCaptcha\Adapter\AdapterInterface;
use RingCaptcha\Adapter\CurlAdapter;
use RingCaptcha\Exception\ExceptionFactory;

class Client
{
    private $options;
    private $adapter;

    public function __construct(array $options, AdapterInterface $adapter = null)
    {
        $this->options = $options;
        $this->adapter = $adapter ?: new CurlAdapter();
    }

    public function code($phone)
    {
        return new Token();
    }

    public function verify(Token $token, $code)
    {
        if (!is_numeric($code)) {
            throw new InvalidCodeException();
        }

        $now = new \DateTime();

        if ($now > $token->getExpirationDate()) {

        }

        throw ExceptionFactory::createFromResponse();
    }
}
