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
        $methodsToExclude = ['PUT', 'PATCH', 'DELETE'];
        $methodsNotToExclude = ['GET', 'POST'];

        $this->flashlight->setConfig(['excluded_methods' => $methodsToExclude]);

        foreach ($methodsToExclude as $method) {
            $request = Request::create('/', $method);
            $this->assertTrue($this->flashlight->httpMethodIsNotLoggable($request));
        }

        foreach ($methodsNotToExclude as $method) {
            $request = Request::create('/', $method);
            $this->assertFalse($this->flashlight->httpMethodIsNotLoggable($request));
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
        $request = Request::create('/', 'GET');

        $this->assertTrue($this->flashlight->log($request));
    }

    /**
     * @test
     *
     * @return void
     */
    public function flashlight_logs_request_header()
    {
        $this->flashlight->setConfig([
            'log_headers' => true,
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
            'log_body' => true,
        ]);

        $request = Request::create('/', 'GET');

        $data = $this->flashlight->extractData($request);

        $this->assertArrayHasKey('body', $data);
        $this->assertNotNull($data['body']);
    }
}
