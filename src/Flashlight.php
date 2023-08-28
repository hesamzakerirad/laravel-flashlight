<?php

namespace HesamRad\Flashlight;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Flashlight
{
    /**
     * The configuration that Flashlight
     * uses to function.
     *
     * @var array
     */
    protected array $config;
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
     * Modifies Flashlight configurations.
     *
     * @param  array $config
     * @return void
     */
    public function setConfig($config = [])
    {
        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }
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
     * Checks to see if Flashlight can write logs
     * to database.
     *
     * @return bool
     */
    public function canLogToDatabase()
    {
        return $this->config('log_to_database') == true;
    }

    /**
     * Checks to see if Flashlight can write logs
     * to database.
     *
     * @return bool
     */
    public function canLogToFile()
    {
        return $this->config('log_to_file') == true;
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
     * Checks to see if request method is loggable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function httpMethodIsNotLoggable(Request $request)
    {
        return in_array(
            strtolower($request->method()), 
            array_map('strtolower', $this->excludedMethods())
        );
    }

    /**
     * Checks to see if request uri is loggable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function uriIsNotLoggable(Request $request)
    {
        return $request->is($this->excludedUris());
    }

    /**
     * Checks to see if request should be ignored.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function shouldBeIgnored(Request $request)
    {
        return $this->httpMethodIsNotLoggable($request) || $this->uriIsNotLoggable($request);
    }

    /**
     * Returns the IP address of the given request
     * instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function getIp(Request $request)
    {
        return $request->ip();
    }

    /**
     * Returns the HTTP method used to send 
     * the given request instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function getMethod(Request $request)
    {
        return $request->method();
    }

    /**
     * Returns the raw path of the given request
     * instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function getAddress(Request $request)
    {
        return $request->getPathInfo();
    }

    /**
     * Returns the header values of the given request
     * instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function getHeaders(Request $request)
    {
        return $this->logHeaders() ? json_encode($request->header()) : null;
    }

    /**
     * Returns the body of the given request
     * instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function getBody(Request $request)
    {
        return $this->logBody() ? json_encode($request->except($this->excludedParameters())) : null;
    }

    /**
     * Extract all the available information
     * from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function extractData(Request $request)
    {
        return [
            'ip' => $this->getIp($request),
            'method' => $this->getMethod($request),
            'address' => $this->getAddress($request),
            'headers' => $this->getHeaders($request),
            'body' => $this->getBody($request),
            'requested_at' => date('Y-m-d H:m:s')
        ];
    }

    /**
     * Stores a log record inside a file.
     *
     * @param  array  $data
     * @return void
     */
    public function logToFile(array $data)
    {
        Log::build([
            'driver' => 'single',
            'path' => $this->config('path_to_log_file')
        ])->info(json_encode($data));
    }

    /**
     * Stores a log record inside the database.
     *
     * @param  array  $data
     * @return void
     */
    public function logToDatabase(array $data)
    {
        DB::table($this->config('logs_table_name'))
            ->insert($data);
    }

    /**
     * Logs the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function log(Request $request)
    {
        $data = $this->extractData($request);

        if ($this->canLogToFile()) {
            $this->logToFile($data);
        }

        if ($this->canLogToDatabase()) {
            $this->logToDatabase($data);
        }
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
