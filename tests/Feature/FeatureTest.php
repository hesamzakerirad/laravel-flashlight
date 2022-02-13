<?php

namespace HesamRad\Flashlight\Tests\Feature;

use HesamRad\Flashlight\Tests\TestCase;
use Illuminate\Http\Request;

class FeatureTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function flashlight_ignores_an_excluded_http_method()
    {
        $methodsToExclude = ['get', 'post', 'put', 'patch', 'delete'];

        $this->flashlight->setConfig(['excluded_methods' => $methodsToExclude]);

        foreach ($methodsToExclude as $method) {
            $request = Request::create('/', $method);
            $this->assertTrue($this->flashlight->httpMethodIsNotLoggable($request));
        }
    }

    /**
     * @test
     *
     * @return void
     */
    public function flashlight_ignores_an_excluded_uri()
    {
        $urisToExclude = ['/', 'some-test-uri*'];

        $this->flashlight->setConfig(['excluded_uris' => $urisToExclude]);

        foreach ($urisToExclude as $uri) {
            $request = Request::create($uri, 'get');
            $this->assertTrue($this->flashlight->uriIsNotLoggable($request));
        }
    }

    /**
     * @test
     *
     * @return void
     */
    public function flashlight_logs_a_request()
    {
        $this->flashlight->setConfig([
            'excluded_parameters' => [],
            'log_headers' => true,
            'log_body' => true,
        ]);

        $request = Request::create('/', 'get');

        $log = json_decode($this->flashlight->format($request), true);

        $this->assertArrayHasKey('ip', $log);
        $this->assertNotNull($log['ip']);

        $this->assertArrayHasKey('method', $log);
        $this->assertNotNull($log['method']);

        $this->assertArrayHasKey('address', $log);
        $this->assertNotNull($log['address']);

        $this->assertArrayHasKey('headers', $log);
        $this->assertNotNull($log['headers']);

        $this->assertArrayHasKey('body', $log);
        $this->assertNotNull($log['body']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function flashlight_logs_request_header()
    {
        $this->flashlight->setConfig([
            'excluded_parameters' => [],
            'log_headers' => true,
            'log_body' => false,
        ]);

        $request = Request::create('/', 'get');

        $log = json_decode($this->flashlight->format($request), true);

        $this->assertArrayHasKey('headers', $log);
        $this->assertNotNull($log['headers']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function flashlight_logs_request_body()
    {
        $this->flashlight->setConfig([
            'excluded_parameters' => [],
            'log_headers' => false,
            'log_body' => true,
        ]);

        $request = Request::create('/', 'get');

        $log = json_decode($this->flashlight->format($request), true);

        $this->assertArrayHasKey('body', $log);
        $this->assertNotNull($log['body']);
    }
}
