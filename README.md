[![Latest Version on Packagist](https://img.shields.io/packagist/v/heidelpay/php-customer-messages.svg?style=flat-square)](https://packagist.org/packages/heidelpay/php-customer-messages)
[![Coverage Status](https://coveralls.io/repos/github/heidelpay/php-customer-messages/badge.svg?branch=master)](https://coveralls.io/github/heidelpay/php-customer-messages?branch=master)
[![Build Status](https://travis-ci.org/heidelpay/php-customer-messages.svg?branch=master)](https://travis-ci.org/heidelpay/php-customer-messages)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/7c9b7df7c38841dbb4d485fe83b86eb4)](https://www.codacy.com/app/heidelpay/php-customer-messages/dashboard)

![Logo](https://dev.heidelpay.de/devHeidelpay_400_180.jpg)

**heidelpay Customer Messages**

This library provides user-friendly output of (error)-messages coming from
the heidelpay API.


***1. Installation***

_Composer_
```
composer require heidelpay/php-customer-messages
```

_manual Installation_

Download the latest release from github and unpack it into a folder of your
choice inside your project.


***2. Implementation***

_Composer_
```
require_once 'path/to/autoload.php;
use Heidelpay\CustomerMessages\CustomerMessage;
```

_manual Installation_
```
require_once 'path/to/php-customer-messages/lib/CustomerMessage.php';
```

Of course, the path needs to match the path from step 1.


***3. Usage***

Assuming you have received an error code from one of our modules or the
heidelpay PHP API and stored it in a variable called `$errorcode`.
To get a message from that code, create a `CustomerMessage` instance:
```
$instance = new \Heidelpay\CustomerMessages\CustomerMessage('de_DE');
```

The constructor takes two (optional) arguments:

1. The locale (e.g. 'en_US', 'de_DE')
2. The path to the locales path (for example you want to use your own locale files) 
containing the .csv files with the codes and messages.

We provide 'de_DE' and 'en_US' locale files with this package. You can find them in the
_lib/locales_ folder. If you want to use one of these, the path doesn't need to be
provided in the constructor.

By default, 'en_US' is used as the locale.


Now you can return or print out the message by calling the `getNessage()` method:

```return $instance->getMessage($errorcode);```
```echo $instance->getMessage($errorcode);```

Error codes are accepted in either the 'XXX.XXX.XXX' or 'HP-Error-XXX.XXX.XXX' format.
