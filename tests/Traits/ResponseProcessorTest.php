<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Traits;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseProcessorTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testProcessResponse(): void
    {
        $responseBody = [$this->faker->md5()];

        $httpMessageStream = $this->createMock(StreamInterface::class);
        $httpMessageStream->expects(self::once())->method('__toString')
            ->willReturn(json_encode($responseBody));

        $httpMessageResponse = $this->createMock(ResponseInterface::class);
        $httpMessageResponse->expects(self::once())->method('getBody')
            ->willReturn($httpMessageStream);

        $responseBodyProcessed = (new ClassWithTraits())->publicProcessResponse($httpMessageResponse);

        self::assertSame($responseBody, $responseBodyProcessed);
    }
}
