<?php
/**
 * This class provides unit tests for the CustomerMessage implementation.
 *
 * @license Use of this software requires acceptance of the License Agreement. See LICENSE file.
 * @copyright Copyright © 2016-present Heidelberger Payment GmbH. All rights reserved.
 * @link https://dev.heidelpay.de/php-customer-messages
 * @author Stephano Vogel
 *
 * @package heidelpay
 * @subpackage php-customer-messages
 * @category php-customer-messages
 */

namespace Heidelpay\Tests\CustomerMessages;

use Heidelpay\CustomerMessages\CustomerMessage;
use Heidelpay\CustomerMessages\Exceptions\MissingLocaleFileException;
use PHPUnit\Framework\TestCase;

class CustomerMessagesTest extends TestCase {

    /**
     * Unit test for the correct locale after object initialization.
     */
    public function testForCorrectLocale()
    {
        $message = new CustomerMessage('de_DE');
        $this->assertEquals('de_DE', $message->getLocale());
    }

    /**
     * Unit test that checks if the output of getMessage will be the same with
     * the default locale, nevertheless 'HPError-' is part of the parameter
     * string or not.
     */
    public function testForCorrectMessageOutput()
    {
        // init instance with defaults (en_US locale, default path)
        $message = new CustomerMessage();

        // expect the correct message when the error number is provided.
        $this->assertEquals('Card expired', $message->getMessage('100.100.303'));

        // expect the correct message when 'HPError' is part of the parameter string
        // instead of only the Error number.
        $this->assertEquals('Card expired', $message->getMessage('HPError-100.100.303'));
    }

    /**
     * Unit test that checks if the default message will be printed if the
     * provided message code does not exist, but the 'Default' value
     * is defined in the locale file.
     */
    public function testForDefaultMessageOutput()
    {
        // initialize the class with defaults (en_US locale, library path).
        $message = new CustomerMessage();

        // we expect the default message, because error 987.654.321 might not exist
        // in the default locale file en_US.csv.
        $this->assertEquals(
            'An unspecified error occured.',
            $message->getMessage('987.654.321')
        );
    }

    /**
     * Unit test that checks if an exception is thrown when the locale file is
     * not present (e.g. because the selected language does not exist).
     */
    public function testForThrownMissingLocaleFileException()
    {
        $this->expectException(MissingLocaleFileException::class);
        $message = new CustomerMessage('ab_CD');
    }

}
