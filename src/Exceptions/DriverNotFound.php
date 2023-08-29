<?php

namespace HesamRad\Flashlight\Exceptions;

class DriverNotFound extends \Exception
{
    /**
     * Create a new instance of this class.
     * 
     * @return void
     */
    public function __construct($driver)
    {
        $message = "Driver `{$driver}` is not found in Flashlight's configurations.";

        parent::__construct($message);
    }
}