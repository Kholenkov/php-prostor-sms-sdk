<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Traits;

use Exception;
use Faker\Factory;
use Faker\Generator;
use Kholenkov\ProstorSmsSdk\Configuration\ApiAccess;
use Kholenkov\ProstorSmsSdk\Configuration\Configuration;
use Kholenkov\ProstorSmsSdk\Configuration\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;

class LoggerTest extends TestCase
{
    private Configuration $configuration;
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();

        $this->configuration = new Configuration(
            new ApiAccess(
                $this->faker->url(),
                $this->faker->md5(),
                $this->faker->md5(),
            ),
            new Logger(
                true,
                true,
            ),
        );
    }

    public function testLogRequest(): void
    {
        $this->expectNotToPerformAssertions();

        $logger = $this->createMock(LoggerInterface::class);

        (new ClassWithTraits($logger))->publicLogRequest(
            $this->configuration,
            $this->faker->md5(),
            '/' . $this->faker->md5(),
            $this->faker->randomElements(),
        );
    }

    public function testLogResponse(): void
    {
        $responseBody = [$this->faker->md5()];

        $httpMessageStream = $this->createMock(StreamInterface::class);
        $httpMessageStream->expects(self::once())->method('__toString')
            ->willReturn(json_encode($responseBody));

        $httpMessageResponse = $this->createMock(ResponseInterface::class);
        $httpMessageResponse->expects(self::once())->method('getBody')
            ->willReturn($httpMessageStream);
        $httpMessageResponse->expects(self::once())->method('getReasonPhrase')
            ->willReturn('Ok');
        $httpMessageResponse->expects(self::once())->method('getStatusCode')
            ->willReturn(200);

        $logger = $this->createMock(LoggerInterface::class);

        (new ClassWithTraits($logger))->publicLogResponse(
            $this->configuration,
            $this->faker->md5(),
            $httpMessageResponse,
        );
    }

    public function testLogThrowable(): void
    {
        $this->expectNotToPerformAssertions();

        $logger = $this->createMock(LoggerInterface::class);

        (new ClassWithTraits($logger))->publicLogThrowable($this->configuration, new Exception());
    }
}
