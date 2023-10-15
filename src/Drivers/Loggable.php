<?php
 
namespace HesamRad\Flashlight\Drivers;

interface Loggable 
{
    /**
     * Log the given data in a specified driver 
     * class implementing this interface.
     *
     * @param  array  $data
     * @return void
     */
    public function log($data);
}