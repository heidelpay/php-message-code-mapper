<?php
/**
 * Short Summary
 *
 * Description
 *
 * @license Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 * @copyright Copyright © 2016-present Heidelberger Payment GmbH. All rights reserved.
 *
 * @link  http://dev.heidelpay.com/heidelpay-php-api/
 *
 * @author  Simon Gabriel <simon.gabriel@heidelpay.de>
 *
 * @package  Heidelpay
 * @subpackage PhpStorm
 * @category ${CATEGORY}
 */
namespace Tests\Unit;

use Autoloader as MessageMapperAutoloader;

require __DIR__ . '\..\..\Autoloader.php';

class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that autoloader includes all required classes.
     *
     * @test
     */
    public function autoloaderShouldProduceAnErrorWhenTheFilesAreNotLoaded()
    {
        $path = realpath(__DIR__. '\\..\\..\\lib\\');
        $regex = '/^' . str_replace('\\', '\\\\', $path) . '\\\\.*\.php$/';
        $filesIncludedBefore  = preg_grep($regex, get_included_files());

        $autoloader = new MessageMapperAutoloader();
        $autoloader::requireAllPhpOnce();
        $filesIncludedAfter  = preg_grep($regex, get_included_files());

        $phpFilesInLib = $this->getPhpFilesInLib($path);

        foreach ($phpFilesInLib as $item) {
            $this->assertArrayNotHasKey($item, array_flip($filesIncludedBefore));
            $this->assertArrayHasKey($item, array_flip($filesIncludedAfter));
        }
    }

    private function getPhpFilesInLib($path)
    {
        $files = [];


        if (!is_dir($path)) {
            return $files;
        }

        $items = scandir($path, SCANDIR_SORT_NONE);

        $fileArrays = [];

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $itemPath = $path . '\\' . $item;
            $files = [];
            if (is_dir($itemPath)) {
                $files = $this->getPhpFilesInLib($itemPath);
            } else {
                if (pathinfo($itemPath)['extension'] === 'php') {
                    $files = [$itemPath];
                }
            }
            $fileArrays[] = $files;
        }

        return array_merge(...$fileArrays);
    }




}
