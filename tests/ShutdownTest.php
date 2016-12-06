<?php

namespace Middlewares\Tests;

use Middlewares\Shutdown;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;

class ShutdownTest extends \PHPUnit_Framework_TestCase
{
    public function testShutdown()
    {
        $request = Factory::createServerRequest();

        $response = (new Dispatcher([
            new Shutdown(),
        ]))->dispatch($request);

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertEquals(503, $response->getStatusCode());
        $this->assertFalse($response->hasHeader('Retry-After'));
        $this->assertNotFalse(strpos((string) $response->getBody(), 'Site under maintenance'));
    }

    public function retryAfterProvider()
    {
        return [
            [120, '120'],
            [new \DateTime('2016/12/12 10:10:30'), 'Mon, 12 Dec 2016 10:10:30 GMT'],
            [new \DateTimeImmutable('2016/12/12 10:10:30'), 'Mon, 12 Dec 2016 10:10:30 GMT'],
        ];
    }

    /**
     * @dataProvider retryAfterProvider
     */
    public function testRetryAfter($duration, $header)
    {
        $request = Factory::createServerRequest();

        $response = (new Dispatcher([
            (new Shutdown())->retryAfter($duration),
        ]))->dispatch($request);

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertEquals(503, $response->getStatusCode());
        $this->assertEquals($header, $response->getHeaderLine('Retry-After'));
        $this->assertNotFalse(strpos((string) $response->getBody(), 'Site under maintenance'));
    }
}
