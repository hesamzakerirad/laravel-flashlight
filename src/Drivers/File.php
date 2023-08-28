<?php 

namespace HesamRad\Flashlight\Drivers;

use Illuminate\Support\Facades\Log;

class File implements Loggable
{
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
            'path' => $this->config('path_to_log_file')
        ])->info(json_encode($data));
    }
}