<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusResponse;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageStatusCollection;
use Kholenkov\ProstorSmsSdk\ValueObject\ResponseStatus;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class GetStatusResponseTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new GetStatusResponse(
            $httpStatusCode = $this->faker->faker->randomElement([200, 400]),
            $status = ResponseStatus::from($this->faker->randomResponseStatus()),
            $messages = new MessageStatusCollection($this->faker->generateMessageStatusObject()),
            $description = $this->faker->faker->realText(),
        );

        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status);
        self::assertSame($messages, $valueObject->messages);
        self::assertSame($description, $valueObject->description);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($httpStatusCode, $array['httpStatusCode']);
        self::assertSame($status, $array['status']);
        self::assertSame($messages, $array['messages']);
        self::assertSame($description, $array['description']);
    }

    public function testFromArrayWhenError(): void
    {
        $valueObject = GetStatusResponse::fromArray(
            $httpStatusCode = 400,
            [
                'status' => $status = 'error',
                'description' => $description = $this->faker->faker->md5(),
            ],
        );

        self::assertInstanceOf(GetStatusResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertNull($valueObject->messages);
        self::assertSame($description, $valueObject->description);
    }

    public function testFromArrayWhenOk(): void
    {
        $valueObject = GetStatusResponse::fromArray(
            $httpStatusCode = 200,
            [
                'status' => $status = 'ok',
                'messages' => $messages = [$this->faker->generateMessageStatusArray()],
            ],
        );

        self::assertInstanceOf(GetStatusResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertSame(json_encode($messages), json_encode($valueObject->messages));
        self::assertNull($valueObject->description);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "status"');

        GetStatusResponse::fromArray(200, ['status' => $this->faker->faker->md5()]);
    }
}
