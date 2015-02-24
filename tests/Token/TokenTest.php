<?php

namespace RingCaptcha\Tests\Token;

use RingCaptcha\Token\Token;

class TokenTest extends \PHPUnit_Framework_TestCase
{
    public function testToken()
    {
        $token = new Token('foo', new \DateTime('-1 week'), new \DateTime());

        $this->assertEquals('foo', $token->getValue());
        $this->assertTrue($token->isExpired());
    }
}
