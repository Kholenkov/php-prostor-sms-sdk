<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Utility\BalanceCollection;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetBalanceResponse;
use Kholenkov\ProstorSmsSdk\ValueObject\ResponseStatus;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class GetBalanceResponseTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new GetBalanceResponse(
            $httpStatusCode = $this->faker->faker->randomElement([200, 400]),
            $status = ResponseStatus::from($this->faker->randomResponseStatus()),
            $balance = new BalanceCollection($this->faker->generateBalanceObject()),
            $description = $this->faker->faker->realText(),
        );

        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status);
        self::assertSame($balance, $valueObject->balance);
        self::assertSame($description, $valueObject->description);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($httpStatusCode, $array['httpStatusCode']);
        self::assertSame($status, $array['status']);
        self::assertSame($balance, $array['balance']);
        self::assertSame($description, $array['description']);
    }

    public function testFromArrayWhenError(): void
    {
        $valueObject = GetBalanceResponse::fromArray(
            $httpStatusCode = 400,
            [
                'status' => $status = 'error',
                'description' => $description = $this->faker->faker->md5(),
            ],
        );

        self::assertInstanceOf(GetBalanceResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertNull($valueObject->balance);
        self::assertSame($description, $valueObject->description);
    }

    public function testFromArrayWhenOk(): void
    {
        $valueObject = GetBalanceResponse::fromArray(
            $httpStatusCode = 200,
            [
                'status' => $status = 'ok',
                'balance' => $balance = [$this->faker->generateBalanceArray()],
            ],
        );

        self::assertInstanceOf(GetBalanceResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertSame(json_encode($balance), json_encode($valueObject->balance));
        self::assertNull($valueObject->description);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "status"');

        GetBalanceResponse::fromArray(200, ['status' => $this->faker->faker->md5()]);
    }
}
