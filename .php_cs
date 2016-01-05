<?php

use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\Fixer\Contrib\HeaderCommentFixer;

$header = <<<EOF
This file is part of the RingCaptcha library.

(c) RingCaptcha

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

HeaderCommentFixer::setHeader($header);

$finder = DefaultFinder::create()
    ->in(__DIR__.'/src')
;

return Config::create()
    ->setUsingCache(true)
    ->fixers(['header_comment', 'ordered_use', 'short_array_syntax'])
    ->finder($finder)
;
