<?php 

namespace HesamRad\Flashlight;

use Illuminate\Support\Facades\Log;

class Flashlight
{
    /**
     * Creates a new flashlight object.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Returns flashlight configuration/s.
     *
     * @param  string|null  $key
     * @return string|null
     */
    public function config(string $key = null)
    {
        return isset($key) ? $this->config[$key] : $this->config;
    }
    
    /**
     * Checks to see if flashlight is enabled.
     *
     * @return bool
     */
    public function enabled()
    {
        return $this->config('enabled') == true;
    }
    
    /**
     * Logs something.
     *
     * @return void
     */
    public function log()
    {
        Log::build([
            'driver' => 'single',
            'path' => $this->config('path_to_log_file')
        ])->info('Hey I am working...');          
    }
    
    /**
     * Calls flashlight to see if it'll run.
     *
     * @return void
     */
    public function call()
    {
        return ! $this->enabled() ?: $this->run();
    }
    
    /**
     * Flashlight starts to work.
     *
     * @return void
     */
    public function run()
    {
        //here's where the magic happens ... 

        $this->log();
    }
}