<?php

namespace HesamRad\Flashlight\Exceptions;

class NoDriverSpecified extends \Exception
{
    /**
     * Create a new instance of this class.
     * 
     * @return void
     */
    public function __construct()
    {
        $message = 'No driver specified; you should select a driver so that Flashlight can function.';

        parent::__construct($message);
    }
}