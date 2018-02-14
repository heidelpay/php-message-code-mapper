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

use FileLoader as MessageMapperFileLoader;

require __DIR__ . '\..\..\FileLoader.php';

class FileLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that file loader includes all php files.
     *
     * @test
     */
    public function autoloaderShouldLoadAllPhpFilesInLibDirectory()
    {
        $path = realpath(__DIR__. '\\..\\..\\lib\\');
        $regex = '/^' . str_replace('\\', '\\\\', $path) . '\\\\.*\.php$/';
        $filesIncludedBefore  = preg_grep($regex, get_included_files());

        $autoloader = new MessageMapperFileLoader();
        $autoloader::requireAllLibs();
        $filesIncludedAfter  = preg_grep($regex, get_included_files());

        $phpFilesInLib = $this->getPhpFilesInLib($path);

        foreach ($phpFilesInLib as $item) {
            $this->assertArrayNotHasKey($item, array_flip($filesIncludedBefore));
            $this->assertArrayHasKey($item, array_flip($filesIncludedAfter));
        }
    }

    private function getPhpFilesInLib($path)
    {
        if (!is_dir($path)) {
            return [];
        }

        // iterate through all items in the given path
        $items = scandir($path, SCANDIR_SORT_DESCENDING);

        $files = [];
        $fileArrays = [];
        foreach ($items as $item) {
            // leave current and previous path out
            if ($item === '.' || $item === '..') {
                continue;
            }

            // prepare complete path of the current item
            $itemPath = $path . '\\' . $item;
            if (is_dir($itemPath)) {
                // scan subdirectories as well
                $fileArrays[] = $this->getPhpFilesInLib($itemPath);
            } else {
                if (pathinfo($itemPath)['extension'] === 'php') {
                    $files[] = $itemPath;
                }
            }
        }
        $fileArrays[] = $files;

        return array_merge(...$fileArrays);
    }
}
