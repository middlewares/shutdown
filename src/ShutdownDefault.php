<?php
declare(strict_types = 1);

namespace Middlewares;

use Middlewares\Utils\Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShutdownDefault implements RequestHandlerInterface
{
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory = null)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $responseFactory = $this->responseFactory ?: Factory::getResponseFactory();

        $response = $responseFactory->createResponse(503);
        $response->getBody()->write(<<<'EOT'
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>503. Site under maintenance</title>
    <style>html{font-family: sans-serif;}</style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Site under maintenance</h1>
</body>
</html>
EOT
        );

        return $response;
    }
}
