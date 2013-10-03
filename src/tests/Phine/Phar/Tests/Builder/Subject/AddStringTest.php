<?php

namespace Phine\Phar\Tests\Builder\Subject;

use PharFileInfo;
use Phine\Phar\Builder;

/**
 * Tests the methods in the {@link AddStringTest} class.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class AddStringTest extends AbstractTestCase
{
    const SUBJECT_ID = Builder::ADD_STRING;

    /**
     * Make sure that we can add a file from a string.
     */
    public function testDoLastStep()
    {
        $contents = file_get_contents(__FILE__);

        $this->invokeSubject(
            array(
                'local' => 'test.php',
                'contents' => $contents
            )
        );

        /** @var PharFileInfo $file */
        $file = $this->phar['test.php'];

        $this->assertEquals(
            $contents,
            file_get_contents($file),
            'Make sure that the string is added.'
        );
    }
}
