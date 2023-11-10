<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetVersionResponse;
use Kholenkov\ProstorSmsSdk\ValueObject\ResponseStatus;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class GetVersionResponseTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new GetVersionResponse(
            $httpStatusCode = $this->faker->faker->randomElement([200, 400]),
            $status = ResponseStatus::from($this->faker->randomResponseStatus()),
            $version = $this->faker->faker->randomElement(['1', '2', '3']),
            $description = $this->faker->faker->realText(),
        );

        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status);
        self::assertSame($version, $valueObject->version);
        self::assertSame($description, $valueObject->description);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($httpStatusCode, $array['httpStatusCode']);
        self::assertSame($status, $array['status']);
        self::assertSame($version, $array['version']);
        self::assertSame($description, $array['description']);
    }

    public function testFromArrayWhenError(): void
    {
        $valueObject = GetVersionResponse::fromArray(
            $httpStatusCode = 400,
            [
                'status' => $status = 'error',
                'description' => $description = $this->faker->faker->md5(),
            ],
        );

        self::assertInstanceOf(GetVersionResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertNull($valueObject->version);
        self::assertSame($description, $valueObject->description);
    }

    public function testFromArrayWhenOk(): void
    {
        $valueObject = GetVersionResponse::fromArray(
            $httpStatusCode = 200,
            [
                'status' => $status = 'ok',
                'version' => $version = $this->faker->faker->randomElement(['1', '2', '3']),
            ],
        );

        self::assertInstanceOf(GetVersionResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertSame($version, $valueObject->version);
        self::assertNull($valueObject->description);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "status"');

        GetVersionResponse::fromArray(200, ['status' => $this->faker->faker->md5()]);
    }
}
