<?php

namespace Middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Interop\Http\Middleware\ServerMiddlewareInterface;
use Interop\Http\Middleware\DelegateInterface;

class Shutdown implements ServerMiddlewareInterface
{
    /**
     * @var callable|string The handler used
     */
    private $handler;

    /**
     * @var array Extra arguments passed to the handler
     */
    private $arguments = [];

    /**
     * Constructor.
     *
     * @param callable|string|null $handler
     */
    public function __construct($handler = 'Middlewares\\ShutdownDefault')
    {
        $this->handler = $handler;
    }

    /**
     * Extra arguments passed to the handler.
     *
     * @return self
     */
    public function arguments()
    {
        $this->arguments = func_get_args();

        return $this;
    }

    /**
     * Process a request and return a response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $arguments = array_merge([$request], $this->arguments);
        $callable = Utils\CallableHandler::resolve($this->handler, $arguments);

        return Utils\CallableHandler::execute($callable, $arguments)->withStatus(503);
    }
}
