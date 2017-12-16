# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## [UNRELEASED]

### Changed

- The request handler used to generate the response must implement `Interop\Http\Server\RequestHandlerInterface`. Removed support for callables.

### Removed

- Removed `arguments()` option.

## [0.6.0] - 2017-11-13

### Changed

- Replaced `http-interop/http-middleware` with  `http-interop/http-server-middleware`.

### Removed

- Removed support for PHP 5.x.

## [0.5.0] - 2017-09-21

### Changed

- Append `.dist` suffix to phpcs.xml and phpunit.xml files
- Changed the configuration of phpcs and php_cs
- Upgraded phpunit to the latest version and improved its config file
- Updated to `http-interop/http-middleware#0.5`

## [0.4.0] - 2017-02-05

### Changed

- Updated to `middlewares/utils#~0.9

## [0.3.0] - 2016-12-26

### Added

- New option `retryAfter()`

### Changed

- Updated tests
- Updated to `http-interop/http-middleware#0.4`
- Updated `friendsofphp/php-cs-fixer#2.0`

## [0.2.0] - 2016-11-27

### Changed

- Updated to `http-interop/http-middleware#0.3`

## 0.1.0 - 2016-10-08

First version

[UNRELEASED]: https://github.com/middlewares/shutdown/compare/v0.6.0...HEAD
[0.6.0]: https://github.com/middlewares/shutdown/compare/v0.5.0...v0.6.0
[0.5.0]: https://github.com/middlewares/shutdown/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/middlewares/shutdown/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/middlewares/shutdown/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/middlewares/shutdown/compare/v0.1.0...v0.2.0
