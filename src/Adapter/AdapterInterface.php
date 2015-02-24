<?php

namespace RingCaptcha\Adapter;

interface AdapterInterface
{
    public function send($path, array $options = array());
}
