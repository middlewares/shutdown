<?php
declare(strict_types = 1);

namespace Middlewares;

use DateTimeInterface;
use Middlewares\Utils\Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Shutdown implements MiddlewareInterface
{
    const RETRY_AFTER = 'Retry-After';

    /**
     * @var callable|null
     */
    private $render;

    /**
     * @var DateTimeInterface|int|null
     */
    private $retryAfter;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(?ResponseFactoryInterface $responseFactory = null)
    {
        $this->responseFactory = $responseFactory ?: Factory::getResponseFactory();
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
     * The function to render the html body
     */
    public function render(callable $render): self
    {
        $this->render = $render;

        return $this;
    }

    /**
     * Process a request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $this->responseFactory->createResponse(503);

        $render = $this->render ?: new ShutdownRender();
        $response->getBody()->write((string) $render($request));

        if (is_int($this->retryAfter)) {
            return $response->withHeader(self::RETRY_AFTER, (string) $this->retryAfter);
        }

        if ($this->retryAfter instanceof DateTimeInterface) {
            return $response->withHeader(self::RETRY_AFTER, $this->retryAfter->format('D, d M Y H:i:s \G\M\T'));
        }

        return $response;
    }
}
