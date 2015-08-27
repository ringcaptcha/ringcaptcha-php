RingCaptcha PHP library
=======================

Library for communicating with the RingCaptcha API, which simplifies the
onboarding and verification of users.

Installation
------------

The recommended way to install the library is through [Composer](http://getcomposer.org/).

```bash
$ composer require ringcaptcha/ringcaptcha-php:~1.0
```

Otherwise, install the library yourself.

Configuration
-------------

The most important part is the creation of the client. Create it once and
reference it from anywhere you want to verify a phone number:

```php
require_once __DIR__.'/vendor/autoload.php';

$client = new Ringcaptcha('<key>', '<secret>');
```

Usage
-----

In order to finish a verification process, you need to verify the received PIN code.

```php
$isValid = $client->isValid($_POST['ringcaptcha_pin_code'], $_POST['ringcaptcha_session_id']);

if (!$isValid) {
    // The PIN code is invalid, do something.
}

$id = $client->getId(); // Returns the transaction ID
$number = $client->getPhoneNumber(); // Returns the normalized phone number
$phoneType = $client->getPhoneType(); // Returns either MOBILE, LANDLINE or VOIP
$carrier = $client->getCarrierName(); // Returns the carrier name
```

License
-------

This library is released under the Apache 2.0 license. See the bundled LICENSE file for details.
