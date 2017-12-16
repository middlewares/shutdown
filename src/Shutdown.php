<?php
declare(strict_types = 1);

namespace Middlewares;

use DateTimeInterface;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Shutdown implements MiddlewareInterface
{
    const RETRY_AFTER = 'Retry-After';

    private $handler;
    private $retryAfter;

    public function __construct(RequestHandlerInterface $handler = null)
    {
        $this->handler = $handler;
    }

    /**
     * Estimated time when the downtime will be complete.
     * (integer for relative seconds or DateTimeInterface).
     *
     * @param DateTimeInterface|int $retryAfter
     */
    public function retryAfter($retryAfter): self
    {
        $this->retryAfter = $retryAfter;

        return $this;
    }

    /**
     * Process a request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestHandler = $this->handler ?: new ShutdownDefault();

        $response = $requestHandler->handle($request)->withStatus(503);

        if (is_int($this->retryAfter)) {
            return $response->withHeader(self::RETRY_AFTER, (string) $this->retryAfter);
        }

        if ($this->retryAfter instanceof DateTimeInterface) {
            return $response->withHeader(self::RETRY_AFTER, $this->retryAfter->format('D, d M Y H:i:s \G\M\T'));
        }

        return $response;
    }
}
