<?php

namespace Middlewares\Tests;

use Middlewares\Shutdown;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\CallableMiddleware;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;

class ShutdownTest extends \PHPUnit_Framework_TestCase
{
    public function testShutdown()
    {
        $response = (new Dispatcher([
            new Shutdown(),
            new CallableMiddleware(function () {
                return new Response();
            }),
        ]))->dispatch(new ServerRequest());

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertEquals(503, $response->getStatusCode());
        $this->assertNotFalse(strpos((string) $response->getBody(), 'Site under maintenance'));
    }
}
