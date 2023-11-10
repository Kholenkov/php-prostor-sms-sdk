<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Utility\Sender;
use Kholenkov\ProstorSmsSdk\ValueObject\SenderName;
use Kholenkov\ProstorSmsSdk\ValueObject\SenderStatus;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class SenderTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new Sender(
            $name = new SenderName($this->faker->faker->md5()),
            $status = SenderStatus::from($this->faker->randomSenderStatus()),
            $info = $this->faker->faker->md5(),
        );

        self::assertSame($name, $valueObject->name);
        self::assertSame($status, $valueObject->status);
        self::assertSame($info, $valueObject->info);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($name, $array['name']);
        self::assertSame($status, $array['status']);
        self::assertSame($info, $array['info']);
    }

    public function testFromArray(): void
    {
        $valueObject = Sender::fromArray([
            'name' => $name = $this->faker->faker->md5(),
            'status' => $status = $this->faker->randomSenderStatus(),
            'info' => $info = $this->faker->faker->md5(),
        ]);

        self::assertInstanceOf(Sender::class, $valueObject);
        self::assertSame($name, (string) $valueObject->name);
        self::assertSame($status, $valueObject->status->value);
        self::assertSame($info, $valueObject->info);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "senders.[0].status"');

        Sender::fromArray(['status' => $this->faker->faker->md5()], 'senders.[0]');
    }
}
