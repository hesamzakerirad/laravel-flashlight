<?php

namespace HesamRad\Flashlight;

use Illuminate\Http\Request;
use HesamRad\Flashlight\Drivers\Loggable;
use HesamRad\Flashlight\Exceptions\DriverNotFound;
use HesamRad\Flashlight\Exceptions\NoDriverSpecified;

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
     * The driver class used to log 
     * the request.
     *
     * @var mixed
     */
    protected mixed $driver;

    /**
     * Creates a new Flashlight object.
     *
     * @param  array  $config
     * @param  string  $driver
     * @return void
     */
    public function __construct(array $config = [], $driver = null)
    {
        $this->setConfig($config);

        $this->setDriver($driver);
    }

    /**
     * Get the given configuration/s.
     * 
     * If no key is specufied, all configuration
     * will be returned.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function getConfig(string $key = null)
    {
        return $key === null ? 
            $this->getConfig : $this->getConfig[$key];
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
            $this->getConfig[$key] = $value;
        }
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function setDriver($driver = null)
    {
        if (is_null($driver)) {
            throw new NoDriverSpecified;
        }

        if (! array_key_exists($driver, $this->getConfig('drivers'))) {
            throw new DriverNotFound($driver);
        }

        $driver = config('flashlight.drivers.' . $driver);

        $this->driver = new $driver['concrete']($driver['path']);

        return $this;
    }


    /**
     * Returns the excluded HTTP methods that 
     * are not supposed to be logged by Flashlight.
     *
     * @return array|null
     */
    public function excludedMethods()
    {
        return $this->getConfig('excluded_methods');
    }

    /**
     * Check if Flashlight is enabled.
     *
     * @return bool
     */
    public function enabled()
    {
        return $this->getConfig('enabled') == true;
    }

    /**
     * Check if Flashlight is disabled.
     *
     * @return bool
     */
    public function disabled()
    {
        return $this->enabled() == false;
    }

    /**
     * Check if Flashlight can log request
     * headers.
     *
     * @return bool
     */
    public function logHeaders()
    {
        return $this->getConfig('log_headers') == true;
    }

    /**
     * Check if Flashlight can log request
     * body.
     *
     * @return bool
     */
    public function logBody()
    {
        return $this->getConfig('log_body') == true;
    }

    /**
     * Returns the excluded URIs that 
     * are not supposed to be logged by Flashlight.
     *
     * @return array|null
     */
    public function excludedUris()
    {
        return $this->getConfig('excluded_uris');
    }

    /**
     * Returns the excluded parameters that 
     * are not supposed to be logged by Flashlight.
     *
     * @return array|null
     */
    public function excludedParameters()
    {
        return $this->getConfig('excluded_parameters');
    }

    /**
     * Check if request method is loggable.
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
     * Check if request uri is loggable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function uriIsNotLoggable(Request $request)
    {
        return $request->is($this->excludedUris());
    }

    /**
     * Check if request should be ignored.
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
     * @return string|null
     */
    public function getHeaders(Request $request)
    {
        return $this->logHeaders() ? 
            json_encode($request->header()) : null;
    }

    /**
     * Returns the body of the given request
     * instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function getBody(Request $request)
    {
        return $this->logBody() ? 
            json_encode($request->except($this->excludedParameters())) : null;
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
     * Logs the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function log(Request $request)
    {
        $data = $this->extractData($request);

        $this->driver->log($data);
    }

    /**
     * Turn The Flashlight on and starting looking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function run(Request $request)
    {
        if ($this->disabled() or $this->shouldBeIgnored($request)) {
            return;
        }

        $this->log($request);
    }
}
