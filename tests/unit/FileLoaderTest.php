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

/** @noinspection PhpIncludeInspection */
require realpath(__DIR__ . '/../../FileLoader.php');

class FileLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that file loader includes all php files.
     *
     * @test
     */
    public function autoloaderShouldLoadAllPhpFilesInLibDirectory()
    {
        $path = realpath(__DIR__. '/../../lib/');
        $regex = '/^' . str_replace(DIRECTORY_SEPARATOR, '\\' . DIRECTORY_SEPARATOR, $path) . '.*\.php$/';

        $filesIncludedBefore  = preg_grep($regex, get_included_files());
        MessageMapperFileLoader::requireAllLibs();
        $filesIncludedAfter  = preg_grep($regex, get_included_files());

        // files that should be loaded
        $phpFilesInLib = $this->getPhpFilesInLib($path);

        fwrite(STDOUT, 'Loaded Files before: ' . print_r($filesIncludedBefore, 1));
        fwrite(STDOUT, 'Loaded Files after: ' . print_r($filesIncludedAfter, 1));
        fwrite(STDOUT, 'Files that should have been loaded: ' . print_r($phpFilesInLib, 1));

        $this->assertGreaterThan(0, count($filesIncludedAfter), 'Error: There are no files loaded at all!');

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
            $itemPath = $path . DIRECTORY_SEPARATOR . $item;
            if (is_dir($itemPath)) {
                // scan subdirectories as well
                $fileArrays[] = $this->getPhpFilesInLib($itemPath);
            } else {
                if (pathinfo($itemPath, PATHINFO_EXTENSION) === 'php') {
                    $files[] = $itemPath;
                }
            }
        }
        $fileArrays[] = $files;

        return array_merge(...$fileArrays);
    }
}
