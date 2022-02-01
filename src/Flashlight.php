<?php

namespace HesamRad\Flashlight;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Flashlight
{
    /**
     * Creates a new Flashlight object.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Returns Flashlight configuration/s.
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
     * are not supposed to be logged by Flashlight.
     *
     * @return array|null
     */
    public function excludedMethods()
    {
        return $this->config('excluded_methods');
    }

    /**
     * Checks to see if Flashlight is enabled.
     *
     * @return bool
     */
    public function enabled()
    {
        return $this->config('enabled') == true;
    }

    /**
     * Checks to see if Flashlight can log request
     * headers.
     *
     * @return bool
     */
    public function logHeaders()
    {
        return $this->config('log_headers') == true;
    }

    /**
     * Checks to see if Flashlight can log request
     * body.
     *
     * @return bool
     */
    public function logBody()
    {
        return $this->config('log_body') == true;
    }

    /**
     * Returns the excluded URIs that 
     * are not supposed to be logged by Flashlight.
     *
     * @return array|null
     */
    public function excludedUris()
    {
        return $this->config('excluded_uris');
    }

    /**
     * Returns the excluded parameters that 
     * are not supposed to be logged by Flashlight.
     *
     * @return array|null
     */
    public function excludedParameters()
    {
        return $this->config('excluded_parameters');
    }

    /**
     * Checks to see if request should be ignored
     * or not.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function shouldBeIgnored(Request $request)
    {
        return
            in_array(strtolower($request->method()), $this->excludedMethods()) ||
            in_array(strtolower($request->path()), $this->excludedUris());
    }

    /**
     * Formats the request in a readble way to be logged.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function format(Request $request)
    {
        return json_encode([
            'ip' => $request->ip(),
            'method' => $request->method(),
            'address' => $request->getPathInfo(),
            'headers' => $this->logHeaders() ? $request->header() : null,
            'body' => $this->logBody() ? $request->except($this->excludedParameters()) : null
        ]);
    }

    /**
     * Logs the request.
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
     * Checks to see if request can be logged.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function check(Request $request)
    {
        return $this->shouldBeIgnored($request) ?: $this->log($request);
    }

    /**
     * Checks so see if Flashlight will run.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function run(Request $request)
    {
        return !$this->enabled() ?: $this->check($request);
    }
}
