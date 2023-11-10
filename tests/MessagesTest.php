<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk;

use Kholenkov\ProstorSmsSdk\Configuration\ApiAccess;
use Kholenkov\ProstorSmsSdk\Configuration\Configuration;
use Kholenkov\ProstorSmsSdk\Configuration\Logger;
use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusQueueRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusResponse;
use Kholenkov\ProstorSmsSdk\Dto\Messages\Message;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageCollection;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageId;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageIdCollection;
use Kholenkov\ProstorSmsSdk\Dto\Messages\SendRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\SendResponse;
use Kholenkov\ProstorSmsSdk\Exception\ApiError;
use Kholenkov\ProstorSmsSdk\Interfaces\HttpClient;
use Kholenkov\ProstorSmsSdk\Messages;
use Kholenkov\ProstorSmsSdk\ValueObject;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;

class MessagesTest extends TestCase
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

    public function testGetStatus(): void
    {
        $request = new GetStatusRequest(
            new MessageIdCollection(
                new MessageId(
                    new ValueObject\MessageId($smscId = $this->faker->faker->md5()),
                ),
            ),
        );

        $responseBody = [
            'status' => 'ok',
            'messages' => [
                [
                    'smscId' => $smscId,
                    'status' => $this->faker->randomMessageStatus(),
                ],
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
            ->with($this->configuration->apiAccess, '/status.json', $request->toArray())
            ->willReturn($httpMessageResponse);


        $service = new Messages(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        self::assertInstanceOf(GetStatusResponse::class, $service->getStatus($request));
    }

    public function testGetStatusWithException(): void
    {
        $request = new GetStatusRequest(
            new MessageIdCollection($this->faker->generateMessageIdObject()),
        );

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
            ->with($this->configuration->apiAccess, '/status.json', $request->toArray())
            ->willReturn($httpMessageResponse);


        $service = new Messages(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        $service->getStatus($request);
    }

    public function testGetStatusQueue(): void
    {
        $request = new GetStatusQueueRequest(
            new ValueObject\MessageStatusQueueName($this->faker->randomString(3, 16)),
        );

        $responseBody = [
            'status' => 'ok',
            'messages' => [
                $this->faker->generateMessageStatusArray(),
                $this->faker->generateMessageStatusArray(),
                $this->faker->generateMessageStatusArray(),
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
            ->with($this->configuration->apiAccess, '/statusQueue.json', $request->toArray())
            ->willReturn($httpMessageResponse);


        $service = new Messages(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        self::assertInstanceOf(GetStatusResponse::class, $service->getStatusQueue($request));
    }

    public function testGetStatusQueueWithException(): void
    {
        $request = new GetStatusQueueRequest(
            new ValueObject\MessageStatusQueueName($this->faker->randomString(3, 16)),
        );

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
            ->with($this->configuration->apiAccess, '/statusQueue.json', $request->toArray())
            ->willReturn($httpMessageResponse);


        $service = new Messages(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        $service->getStatusQueue($request);
    }

    public function testSend(): void
    {
        $request = new SendRequest(
            new MessageCollection(
                new Message(
                    new ValueObject\MessageId($clientId = $this->faker->faker->md5()),
                    new ValueObject\PhoneNumber($this->faker->randomPhoneNumber()),
                    $this->faker->faker->realText(),
                ),
            ),
        );

        $responseBody = [
            'status' => 'ok',
            'messages' => [
                [
                    'smscId' => $this->faker->faker->md5(),
                    'status' => $this->faker->randomMessageStatus(),
                    'clientId' => $clientId,
                ],
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
            ->with($this->configuration->apiAccess, '/send.json', $request->toArray())
            ->willReturn($httpMessageResponse);


        $service = new Messages(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        self::assertInstanceOf(SendResponse::class, $service->send($request));
    }

    public function testSendWithException(): void
    {
        $request = new SendRequest(
            new MessageCollection($this->faker->generateMessageObject()),
        );

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
            ->with($this->configuration->apiAccess, '/send.json', $request->toArray())
            ->willReturn($httpMessageResponse);


        $service = new Messages(
            $this->configuration,
            $httpClient,
            $this->createMock(LoggerInterface::class),
        );

        $service->send($request);
    }
}
