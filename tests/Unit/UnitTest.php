<?php

namespace HesamRad\Flashlight\Tests\Unit;

use HesamRad\Flashlight\Tests\TestCase;

class UnitTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function flashlight_can_be_enabled()
    {
        $this->flashlight->setConfig(['enabled' => true]);

        $this->assertTrue($this->flashlight->enabled());
    }

    /**
     * @test
     *
     * @return void
     */
    public function flashlight_can_be_disabled()
    {
        $this->flashlight->setConfig(['enabled' => false]);

        $this->assertFalse($this->flashlight->enabled());
    }
}
