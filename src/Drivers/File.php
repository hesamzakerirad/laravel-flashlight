<?php 

namespace HesamRad\Flashlight\Drivers;

use Illuminate\Support\Facades\Log;

class File implements Loggable
{
    /**
     * The path where the log file resides.
     *
     * @var string
     */
    protected string $path;

    /**
     * Create a new instance of this class.
     *
     * @param  string  $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Log the given data in a file.
     *
     * @param  array  $data
     * @return void
     */
    public function log($data)
    {
        Log::build([
            'driver' => 'single',
            'path' => $this->path
        ])->info(json_encode($data));
    }
}