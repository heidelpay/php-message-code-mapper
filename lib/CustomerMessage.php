<?php

namespace Heidelpay\CustomerMessages;

use Heidelpay\CustomerMessages\Exceptions\MissingLocaleFileException;
use Heidelpay\CustomerMessages\Helpers\FileSystem;

class CustomerMessage
{
    /*
     * @var FileSystem
     */
    private $_filesystem = null;

    /*
     * @var string
     */
    private $_locale;

    /*
     * @var string
     */
    private $_path;

    /*
     * @var array
     */
    private $_messages;

    public function __construct($locale = 'en_US', $path = null)
    {
        $this->_locale = $locale;

        if ( $path ) {
            $this->_path = $path;
        }

        // if the locale file does not exist, we better throw an exception
        // instead of just let PHP error_log something.
        if ( ! file_exists($this->getLocalePath()) ) {
            throw new MissingLocaleFileException(
                "Locale file {$this->getLocalePath()} does not exist."
            );
        }

        // create an array of all message codes and messages
        // to prevent accessing the file each time.
        $this->setContent();
    }

    /**
     * Returns the locale name.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->_locale;
    }

    /**
     * Returns the full path for the locale file.
     *
     * @return string
     */
    public function getLocalePath()
    {
        return $this->getPath() . '/' . $this->getLocale() . '.csv';
    }

    /**
     * Returns the path for the locale file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->_path ?: __DIR__ . '/locales';
    }

    /**
     * Returns a message for the given error code.
     *
     * @param $errorcode
     * @return string
     */
    public function getMessage($errorcode)
    {
        if( preg_match('/^\d{3}\.\d{3}\.\d{3}$/', $errorcode) ) {
            $errorcode = 'HPError-' . $errorcode;
        }

        // PHP7 way: return $this->_messages[$errorcode] ?? '';
        return isset($this->_messages[$errorcode])
            ? $this->_messages[$errorcode]
            : "{$errorcode} - No message specified.";
    }

    /**
     *
     */
    private function setContent()
    {
        // open the fs to retrieve file information.
        $this->_filesystem = new FileSystem($this->getLocalePath());
        $this->_messages = $this->_filesystem->getCsvContent();
    }

}