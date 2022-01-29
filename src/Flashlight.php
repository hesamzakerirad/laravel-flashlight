<?php 

namespace HesamRad\Flashlight;

use Illuminate\Http\Request; 
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
     * @return mixed
     */
    public function config(string $key = null)
    {
        return isset($key) ? $this->config[$key] : $this->config;
    }

    /**
     * Returns the excluded HTTP methods that 
     * are not supposed to be logged by flashlight.
     *
     * @return array|null
     */
    public function excludedMethods()
    {
        return $this->config('excluded_methods');
    }

    /**
     * Returns the excluded URIs that 
     * are not supposed to be logged by flashlight.
     *
     * @return array|null
     */
    public function excludedUris()
    {
        return $this->config('excluded_uris');
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
     * Prepares the request to be logged.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function prepare(Request $request)
    {
        return $this->shouldBeIgnored($request) ?: $this->log($request);          
    }

    /**
     * Checks to see if request can be logged.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function shouldBeIgnored(Request $request) 
    {
        return 
            in_array($request->method(), $this->excludedMethods()) || 
            in_array($request->path(), $this->excludedUris());
    }

    /**
     * Formats the request in a readble way to be logged.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function format(Request $request)
    {
        return $request->ip() . ' ' . $request->method() . ' ' . $request->path();
    }

    /**
     * Undocumented function
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function log(Request $request) 
    {
        Log::build([
            'driver' => 'single',
            'path' => $this->config('path_to_log_file')
        ])->info($this->format($request));
    }
    
    /**
     * Calls flashlight to see if it'll run.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function call(Request $request)
    {
        return ! $this->enabled() ?: $this->run($request);
    }
    
    /**
     * Flashlight starts to work.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function run(Request $request)
    {
        $this->prepare($request);

        //other stuff are coming up... :)
    }
}