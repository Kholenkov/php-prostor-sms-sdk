<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk;

use Kholenkov\ProstorSmsSdk\Configuration\ApiAccess;
use Kholenkov\ProstorSmsSdk\Configuration\Configuration;
use Kholenkov\ProstorSmsSdk\Configuration\Logger;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetBalanceResponse;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetSendersResponse;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetVersionResponse;
use Kholenkov\ProstorSmsSdk\Exception\ApiError;
use Kholenkov\ProstorSmsSdk\Interfaces\HttpClient;
use Kholenkov\ProstorSmsSdk\Utility;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;

class UtilityTest extends TestCase
{
    private Configuration $configuration;
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();

        $this->configuration = new Configuration(
            new ApiAccess(
                $this->faker->faker->url(),
                $this->faker->faker->md5(),
                $this->faker->faker->md5(),
            ),
            new Logger(),
        );
    }

    public function testGetBalance(): void
    {
        $responseBody = [
            'status' => 'ok',
            'balance' => [
                $this->faker->generateBalanceArray(),
                $this->faker->generateBalanceArray(),
                $this->faker->generateBalanceArray(),
            ],
        ];


        $httpMessageStream = $this->createMock(StreamInterface::class);
        $httpMessageStream->expects(self::once())->method('__toString')
            ->willReturn(json_encode($responseBody));

        $httpMessageResponse = $this->createMock(ResponseInterface::class);
        $httpMessageResponse->expects(self::once())->method('getStatusCode')
            ->willReturn(200);
        $httpMessageResponse->expects(self::once())->method('getBody')
            ->willReturn($httpMessageStream);

        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects(self::once())->method('post')
            ->with($this->configuration->apiAccess, '/balance.json')
            ->willReturn($httpMessageResponse);


        $service = new Utility(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        self::assertInstanceOf(GetBalanceResponse::class, $service->getBalance());
    }

    public function testGetBalanceWithException(): void
    {
        $this->expectException(ApiError::class);
        $this->expectExceptionMessage('Invalid response body');


        $httpMessageStream = $this->createMock(StreamInterface::class);
        $httpMessageStream->expects(self::once())->method('__toString')
            ->willReturn('');

        $httpMessageResponse = $this->createMock(ResponseInterface::class);
        $httpMessageResponse->expects(self::once())->method('getStatusCode')
            ->willReturn(400);
        $httpMessageResponse->expects(self::once())->method('getBody')
            ->willReturn($httpMessageStream);

        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects(self::once())->method('post')
            ->with($this->configuration->apiAccess, '/balance.json')
            ->willReturn($httpMessageResponse);


        $service = new Utility(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        $service->getBalance();
    }

    public function testGetSenders(): void
    {
        $responseBody = [
            'status' => 'ok',
            'senders' => [
                $this->faker->generateSenderArray(),
                $this->faker->generateSenderArray(),
                $this->faker->generateSenderArray(),
            ],
        ];


        $httpMessageStream = $this->createMock(StreamInterface::class);
        $httpMessageStream->expects(self::once())->method('__toString')
            ->willReturn(json_encode($responseBody));

        $httpMessageResponse = $this->createMock(ResponseInterface::class);
        $httpMessageResponse->expects(self::once())->method('getStatusCode')
            ->willReturn(200);
        $httpMessageResponse->expects(self::once())->method('getBody')
            ->willReturn($httpMessageStream);

        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects(self::once())->method('post')
            ->with($this->configuration->apiAccess, '/senders.json')
            ->willReturn($httpMessageResponse);


        $service = new Utility(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        self::assertInstanceOf(GetSendersResponse::class, $service->getSenders());
    }

    public function testGetSendersWithException(): void
    {
        $this->expectException(ApiError::class);
        $this->expectExceptionMessage('Invalid response body');


        $httpMessageStream = $this->createMock(StreamInterface::class);
        $httpMessageStream->expects(self::once())->method('__toString')
            ->willReturn('');

        $httpMessageResponse = $this->createMock(ResponseInterface::class);
        $httpMessageResponse->expects(self::once())->method('getStatusCode')
            ->willReturn(400);
        $httpMessageResponse->expects(self::once())->method('getBody')
            ->willReturn($httpMessageStream);

        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects(self::once())->method('post')
            ->with($this->configuration->apiAccess, '/senders.json')
            ->willReturn($httpMessageResponse);


        $service = new Utility(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        $service->getSenders();
    }

    public function testGetVersion(): void
    {
        $responseBody = [
            'status' => 'ok',
            'version' => $this->faker->faker->randomElement(['1', '2', '3']),
        ];


        $httpMessageStream = $this->createMock(StreamInterface::class);
        $httpMessageStream->expects(self::once())->method('__toString')
            ->willReturn(json_encode($responseBody));

        $httpMessageResponse = $this->createMock(ResponseInterface::class);
        $httpMessageResponse->expects(self::once())->method('getStatusCode')
            ->willReturn(200);
        $httpMessageResponse->expects(self::once())->method('getBody')
            ->willReturn($httpMessageStream);

        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects(self::once())->method('post')
            ->with($this->configuration->apiAccess, '/version.json')
            ->willReturn($httpMessageResponse);


        $service = new Utility(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        self::assertInstanceOf(GetVersionResponse::class, $service->getVersion());
    }

    public function testGetVersionWithException(): void
    {
        $this->expectException(ApiError::class);
        $this->expectExceptionMessage('Invalid response body');


        $httpMessageStream = $this->createMock(StreamInterface::class);
        $httpMessageStream->expects(self::once())->method('__toString')
            ->willReturn('');

        $httpMessageResponse = $this->createMock(ResponseInterface::class);
        $httpMessageResponse->expects(self::once())->method('getStatusCode')
            ->willReturn(400);
        $httpMessageResponse->expects(self::once())->method('getBody')
            ->willReturn($httpMessageStream);

        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->expects(self::once())->method('post')
            ->with($this->configuration->apiAccess, '/version.json')
            ->willReturn($httpMessageResponse);


        $service = new Utility(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        $service->getVersion();
    }
}
