<?php
declare(strict_types = 1);

namespace Middlewares;

use Interop\Http\Server\RequestHandlerInterface;
use Middlewares\Utils\Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShutdownDefault implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = Factory::createResponse(503);
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
