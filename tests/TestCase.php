<?php

namespace HesamRad\Flashlight\Tests;

use HesamRad\Flashlight\Flashlight;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Our Flashlight instance
     *
     * @var object
     */
    protected $flashlight;

    /**
     * Setting up our testcase.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $config = require (__DIR__ . '/../config/flashlight.php');

        $this->flashlight = new Flashlight($config, 'file');
    }
}
