# middlewares/shutdown

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]
[![SensioLabs Insight][ico-sensiolabs]][link-sensiolabs]

Middleware to display a `503` maintenance page.

## Requirements

* PHP >= 5.6
* A [PSR-7](https://packagist.org/providers/psr/http-message-implementation) http mesage implementation ([Diactoros](https://github.com/zendframework/zend-diactoros), [Guzzle](https://github.com/guzzle/psr7), [Slim](https://github.com/slimphp/Slim), etc...)
* A [PSR-15 middleware dispatcher](https://github.com/middlewares/awesome-psr15-middlewares#dispatcher)

## Installation

This package is installable and autoloadable via Composer as [middlewares/shutdown](https://packagist.org/packages/middlewares/shutdown).

```sh
composer require middlewares/shutdown
```

## Example

```php
$dispatcher = new Dispatcher([
	(new Middlewares\Shutdown())->retryAfter(60 * 5)
]);

$response = $dispatcher->dispatch(new ServerRequest());
```

## Options

#### `__construct(string|callable $handler = null)`

Assign the callable used to generate the response. It can be a callable or a string with the format `Class::method`. The signature of the handler is the following:

```php
use Psr\Http\Message\RequestInterface;

$handler = function (RequestInterface $request) {
    //Any output is captured and added to the body stream
    echo 'Site under maintenance';
};

$dispatcher = new Dispatcher([
    new Middlewares\Shutdown($handler)
]);

$response = $dispatcher->dispatch(new Request());
```

If it's not provided, [the default](src/ShutdownDefault.php) will be used.

#### `retryAfter(int|DateTimeInterface $duration)`

If known, the length of the downtime in seconds or the estimated date and time when the downtime will be complete. [More info about why this](https://webmasters.googleblog.com/2011/01/how-to-deal-with-planned-site-downtime.html)

#### `arguments(...$args)`

Extra arguments to pass to the error handler.


---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/shutdown.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/middlewares/shutdown/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/middlewares/shutdown.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/shutdown.svg?style=flat-square
[ico-sensiolabs]: https://img.shields.io/sensiolabs/i/117e9e9d-e4c2-425f-a83d-198e1f292962.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/shutdown
[link-travis]: https://travis-ci.org/middlewares/shutdown
[link-scrutinizer]: https://scrutinizer-ci.com/g/middlewares/shutdown
[link-downloads]: https://packagist.org/packages/middlewares/shutdown
[link-sensiolabs]: https://insight.sensiolabs.com/projects/117e9e9d-e4c2-425f-a83d-198e1f292962
