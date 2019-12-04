<?php
declare(strict_types = 1);

namespace Middlewares;

class ShutdownRender
{
    public function __invoke(): string
    {
        return <<<'EOT'
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
EOT;
    }
}
