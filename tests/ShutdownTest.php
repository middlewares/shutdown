<?php

namespace Middlewares\Tests;

use Middlewares\Shutdown;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use mindplay\middleman\Dispatcher;

class ShutdownTest extends \PHPUnit_Framework_TestCase
{
    public function testShutdown()
    {
        $response = (new Dispatcher([
            new Shutdown(),
            function () {
                return new Response();
            },
        ]))->dispatch(new Request());

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);
        $this->assertEquals(503, $response->getStatusCode());
        $this->assertNotFalse(strpos((string) $response->getBody(), 'Site under maintenance'));
    }
}
