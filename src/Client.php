<?php

namespace RingCaptcha;

use RingCaptcha\Exception\BadMethodCallException;
use RingCaptcha\Exception\InvalidArgumentException;
use RingCaptcha\HttpClient\HttpClientInterface;

class Client
{
    const VERSION = '2.0.0-dev';

    private $options;
    private $httpClient;

    public function __construct(array $options, HttpClientInterface $httpClient = null)
    {
        $this->options = array_merge([], $options);
        $this->httpClient = $httpClient;
    }

    public function api($name)
    {
        switch ($name) {
            case 'verification':
                # code...
                break;
            
            default:
                throw new InvalidArgumentException();
        }
    }

    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = 1;
        }

        return $this->httpClient;
    }

    public function __call($name, $arguments)
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }
}
