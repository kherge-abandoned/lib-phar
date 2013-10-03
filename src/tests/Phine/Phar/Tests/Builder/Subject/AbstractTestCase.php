<?php

namespace Phine\Phar\Tests\Builder\Subject;

use Phar;
use Phine\Phar\Builder;
use Phine\Phar\Builder\Arguments;
use Phine\Phar\Builder\Subject\AbstractSubject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Simplifies the process for writing test cases for builder event subjects.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * The subject ID being tested.
     */
    const SUBJECT_ID = 'REPLACE ME';

    /**
     * The builder for the subject.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * The test PHP archive file path.
     *
     * @var string
     */
    protected $file;

    /**
     * The test PHP archive instance.
     *
     * @var Phar
     */
    protected $phar;

    /**
     * The subject being tested.
     *
     * @var AbstractSubject
     */
    protected $subject;

    /**
     * Sets the arguments and and updates the subject's observers.
     *
     * @param array $args The method arguments.
     */
    protected function invokeSubject(array $args)
    {
        $this->subject->setArguments(new Arguments($args));
        $this->subject->notifyObservers();
    }

    /**
     * Creates a new PHP archive and {@link Builder} instance for testing.
     */
    protected function setUp()
    {
        unlink($this->file = tempnam(sys_get_temp_dir(), 'phar'));

        $this->file .= '.phar';

        $this->phar = new Phar($this->file);
        $this->builder = new Builder($this->phar);
        $this->subject = $this->builder->getSubject(static::SUBJECT_ID);
    }

    /**
     * Cleans up the temporary PHP archive.
     */
    protected function tearDown()
    {
        $this->phar = null;

        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }
}
