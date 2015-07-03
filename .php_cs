<?php

use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;

$finder = DefaultFinder::create()
    ->in(__DIR__)
;

return Config::create()
    ->setUsingCache(true)
    ->fixers(['ordered_use', 'short_array_syntax'])
    ->finder($finder)
;
