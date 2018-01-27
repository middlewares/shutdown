<?php
declare(strict_types = 1);

namespace Middlewares\Tests;

use Middlewares\Shutdown;
use Middlewares\Utils\Dispatcher;
use PHPUnit\Framework\TestCase;

class ShutdownTest extends TestCase
{
    public function testShutdown()
    {
        $response = Dispatcher::run([
            new Shutdown(),
        ]);

        $this->assertEquals(503, $response->getStatusCode());
        $this->assertFalse($response->hasHeader('Retry-After'));
        $this->assertNotFalse(strpos((string) $response->getBody(), 'Site under maintenance'));
    }

    public function retryAfterProvider(): array
    {
        return [
            [120, '120'],
            [new \DateTime('2016/12/12 10:10:30'), 'Mon, 12 Dec 2016 10:10:30 GMT'],
            [new \DateTimeImmutable('2016/12/12 10:10:30'), 'Mon, 12 Dec 2016 10:10:30 GMT'],
        ];
    }

    /**
     * @dataProvider retryAfterProvider
     *
     * @param int|DateTimeInterface $duration
     */
    public function testRetryAfter($duration, string $header)
    {
        $response = Dispatcher::run([
            (new Shutdown())->retryAfter($duration),
        ]);

        $this->assertEquals(503, $response->getStatusCode());
        $this->assertEquals($header, $response->getHeaderLine('Retry-After'));
        $this->assertNotFalse(strpos((string) $response->getBody(), 'Site under maintenance'));
    }
}
