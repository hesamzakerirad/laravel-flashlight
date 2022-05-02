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
        $methodsToExclude = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

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

        $request = Request::create('/', 'GET');

        $data = $this->flashlight->extractData($request);

        $this->assertArrayHasKey('ip', $data);
        $this->assertNotNull($data['ip']);

        $this->assertArrayHasKey('method', $data);
        $this->assertNotNull($data['method']);

        $this->assertArrayHasKey('address', $data);
        $this->assertNotNull($data['address']);

        $this->assertArrayHasKey('headers', $data);
        $this->assertNotNull($data['headers']);

        $this->assertArrayHasKey('body', $data);
        $this->assertNotNull($data['body']);
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

        $request = Request::create('/', 'GET');

        $data = $this->flashlight->extractData($request);

        $this->assertArrayHasKey('headers', $data);
        $this->assertNotNull($data['headers']);
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

        $request = Request::create('/', 'GET');

        $data = $this->flashlight->extractData($request);

        $this->assertArrayHasKey('body', $data);
        $this->assertNotNull($data['body']);
    }
}
