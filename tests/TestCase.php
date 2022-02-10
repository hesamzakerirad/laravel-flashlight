<?php

namespace HesamRad\Flashlight\Tests;

use HesamRad\Flashlight\Flashlight;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;

class TestCase extends PHPUnit_TestCase
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

        //I only instantiate an object with no configuration 
        //to work with it during tests.
        $this->flashlight = new Flashlight($config = []);
    }
}
