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
        $this->flashlight->enable();

        $this->assertTrue($this->flashlight->isEnabled());
    }

    /**
     * @test
     *
     * @return void
     */
    public function flashlight_can_be_disabled()
    {
        $this->flashlight->disable();

        $this->assertTrue($this->flashlight->isDisabled());
    }
}
