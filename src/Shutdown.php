<?php

namespace Middlewares;

use DateTimeInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Middlewares\Utils\CallableResolver\ReflectionResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Shutdown implements MiddlewareInterface
{
    const RETRY_AFTER = 'Retry-After';

    /**
     * @var callable|string The handler used
     */
    private $handler;

    /**
     * @var array Extra arguments passed to the handler
     */
    private $arguments = [];

    /**
     * @var DateTimeInterface|int|null Extra arguments passed to the handler
     */
    private $retryAfter;

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
     * Estimated time when the downtime will be complete.
     * (integer for relative seconds or DateTimeInterface).
     *
     * @param DateTimeInterface|int $retryAfter
     *
     * @return self
     */
    public function retryAfter($retryAfter)
    {
        $this->retryAfter = $retryAfter;

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
        $callable = (new ReflectionResolver())->resolve($this->handler, $arguments);

        $response = Utils\CallableHandler::execute($callable, $arguments)->withStatus(503);

        if (is_int($this->retryAfter)) {
            return $response->withHeader(self::RETRY_AFTER, (string) $this->retryAfter);
        }

        if ($this->retryAfter instanceof DateTimeInterface) {
            return $response->withHeader(self::RETRY_AFTER, $this->retryAfter->format('D, d M Y H:i:s \G\M\T'));
        }

        return $response;
    }
}
