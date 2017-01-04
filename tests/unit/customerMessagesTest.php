<?php
namespace Heidelpay\Tests\CustomerMessages;

use Heidelpay\CustomerMessages\CustomerMessage;
use Heidelpay\CustomerMessages\Exceptions\MissingLocaleFileException;
use PHPUnit\Framework\TestCase;

class CustomerMessagesTest extends TestCase {

    /**
     * Unit test for the correct locale after
     * object initialization.
     */
    public function testForCorrectLocale()
    {
        $message = new CustomerMessage('de_DE');
        $this->assertEquals('de_DE', $message->getLocale());
    }

    /**
     * Unit test that checks if the default message will be printed
     * if the provided message code does not exist, but the
     * 'Default' value is present in the locale file.
     */
    public function testForDefaultMessageOutput()
    {
        // initialize the class with default locale (en_US).
        $message = new CustomerMessage();

        // we expect the default message, because error 987.654.321 might not exist
        // in the default locale file en_US.csv.
        $this->assertEquals(
            'An unspecified error occured.',
            $message->getMessage('987.654.321')
        );
    }

    /**
     * Unit test that checks if an exception is thrown when
     * the locale file is not present.
     */
    public function testForThrownMissingLocaleFileException()
    {
        try {
            // init the object with a not existing locale.
            $message = new CustomerMessage('ab_CD');

            // Print a message, if no exception has been thrown.
            $this->fail('No exception has been thrown.');

        } catch( MissingLocaleFileException $mlfe ) {
            $this->assertEquals(404, $mlfe->getCode());
        }
    }

}
