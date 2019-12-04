# middlewares/shutdown

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]

Middleware to display a `503` maintenance page.

## Requirements

* PHP >= 7.2
* A [PSR-7 http library](https://github.com/middlewares/awesome-psr15-middlewares#psr-7-implementations)
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

## Usage

This middleware generates a `503` response to display while the server is in maintenance. Optionally, you can provide a `Psr\Http\Message\ResponseFactoryInterface` used to create the responses. If it's not defined, [Middleware\Utils\Factory](https://github.com/middlewares/utils#factory) will be used to detect it automatically.

```php
$responseFactory = new MyOwnResponseFactory();

$maintenance = new Middlewares\Shutdown($responseFactory);
```

### retryAfter

If known, the length of the downtime in seconds or the estimated date and time when the downtime will be complete. [More info about why this](https://webmasters.googleblog.com/2011/01/how-to-deal-with-planned-site-downtime.html)


```php
//Retry after 5 minutes
$maintenance = (new Middlewares\Shutdown())->retryAfter(60 * 5);

//You can use also a DateTimeInterface object
$maintenance = (new Middlewares\Shutdown())->retryAfter(new Datetime('+5 minutes'));
```

### render

Use this option to customize the content of the response by providing a callable that returns a string:

```php
//Load a html file
$maintenance = (new Middlewares\Shutdown())->render(function () {
	return file_get_contents('503.html');
});
```

---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/shutdown.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/middlewares/shutdown/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/middlewares/shutdown.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/shutdown.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/shutdown
[link-travis]: https://travis-ci.org/middlewares/shutdown
[link-scrutinizer]: https://scrutinizer-ci.com/g/middlewares/shutdown
[link-downloads]: https://packagist.org/packages/middlewares/shutdown
