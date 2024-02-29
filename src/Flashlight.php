<?php

namespace HesamRad\Flashlight;

use Illuminate\Http\Request;
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
     * The driver used to log the request.
     *
     * @var \HesamRad\Flashlight\Drivers\Loggable
     */
    protected $driver;

    /**
     * Creates a new Flashlight object.
     *
     * @param  array  $config
     * @param  string  $driver
     * @return void
     */
    public function __construct(array $config = [], $driver = null)
    {
        $this->config = $config;

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
        if ($key === null) {
            return $this->config;
        }

        if (! isset($this->config[$key])) {
            return null;
        }

        return $this->config[$key];
    }

    /**
     * Modifies Flashlight configurations.
     *
     * @param  array $config
     * @return self
     */
    public function setConfig($config = [])
    {
        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Undocumented function
     *
     * @param  string  $driver
     * @return self
     */
    public function setDriver($driver = null)
    {
        if ($driver === null) {
            throw new NoDriverSpecified;
        }

        if (! array_key_exists($driver, $this->getConfig('drivers'))) {
            throw new DriverNotFound($driver);
        }

        $driver = $this->getConfig('drivers')[$driver];

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
     * Enable the Flashlight to start 
     * logging all incoming requests.
     *
     * @return void
     */
    public function enable()
    {
        return $this->setConfig(['enabled' => true]);
    }

    /**
     * Check if Flashlight is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getConfig('enabled') == true;
    }

    /**
     * Disable the Flashlight to stop 
     * logging all incoming requests.
     *
     * @return void
     */
    public function disable()
    {
        return $this->setConfig(['enabled' => false]);
    }

    /**
     * Check if Flashlight is disabled.
     *
     * @return bool
     */
    public function isDisabled()
    {
        return $this->isEnabled() == false;
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
     * @return boolean
     */
    public function log(Request $request)
    {
        $data = $this->extractData($request);

        try {
            $this->driver->log($data);
        } 
        catch (\Throwable $th) {
            return false;
        }

        return true;
    }

    /**
     * Turn The Flashlight on and starting looking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function run(Request $request)
    {
        if ($this->isDisabled() or $this->shouldBeIgnored($request)) {
            return;
        }

        $this->log($request);
    }
}
