<?php

namespace HesamRad\Flashlight\Tests\Unit;

use HesamRad\Flashlight\Tests\TestCase;
 
class UnitTest extends TestCase
{
    public function test_if_flashlight_can_be_enabled() : void
    {
        $this->flashlight->setConfig('enabled', true);

        $this->assertTrue($this->flashlight->enabled());
    }

    public function test_if_flashlight_can_be_disabled() : void
    {
        $this->flashlight->setConfig('enabled', false);

        $this->assertFalse($this->flashlight->enabled());
    }
}
