<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetSendersResponse;
use Kholenkov\ProstorSmsSdk\Dto\Utility\SenderCollection;
use Kholenkov\ProstorSmsSdk\ValueObject\ResponseStatus;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class GetSendersResponseTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new GetSendersResponse(
            $httpStatusCode = $this->faker->faker->randomElement([200, 400]),
            $status = ResponseStatus::from($this->faker->randomResponseStatus()),
            $senders = new SenderCollection($this->faker->generateSenderObject()),
            $description = $this->faker->faker->realText(),
        );

        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status);
        self::assertSame($senders, $valueObject->senders);
        self::assertSame($description, $valueObject->description);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($httpStatusCode, $array['httpStatusCode']);
        self::assertSame($status, $array['status']);
        self::assertSame($senders, $array['senders']);
        self::assertSame($description, $array['description']);
    }

    public function testFromArrayWhenError(): void
    {
        $valueObject = GetSendersResponse::fromArray(
            $httpStatusCode = 400,
            [
                'status' => $status = 'error',
                'description' => $description = $this->faker->faker->md5(),
            ],
        );

        self::assertInstanceOf(GetSendersResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertNull($valueObject->senders);
        self::assertSame($description, $valueObject->description);
    }

    public function testFromArrayWhenOk(): void
    {
        $valueObject = GetSendersResponse::fromArray(
            $httpStatusCode = 200,
            [
                'status' => $status = 'ok',
                'senders' => $senders = [$this->faker->generateSenderArray()],
            ],
        );

        self::assertInstanceOf(GetSendersResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertSame(json_encode($senders), json_encode($valueObject->senders));
        self::assertNull($valueObject->description);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "status"');

        GetSendersResponse::fromArray(200, ['status' => $this->faker->faker->md5()]);
    }
}
