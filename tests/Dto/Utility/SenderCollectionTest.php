<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Utility\Sender;
use Kholenkov\ProstorSmsSdk\Dto\Utility\SenderCollection;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class SenderCollectionTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $values = [
            $this->faker->generateSenderObject(),
            $this->faker->generateSenderObject(),
            $this->faker->generateSenderObject(),
        ];


        $valueObject = new SenderCollection(...$values);

        self::assertCount(3, $valueObject);

        foreach ($valueObject as $key => $value) {
            self::assertInstanceOf(Sender::class, $value);
            self::assertSame($values[$key], $value);
        }


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertCount(3, $array);

        foreach ($array as $key => $value) {
            self::assertIsArray($value);
            self::assertSame($values[$key]->jsonSerialize(), $value);
        }
    }

    public function testFromArray(): void
    {
        $valueObject = SenderCollection::fromArray([
            $this->faker->generateSenderArray(),
            $this->faker->generateSenderArray(),
            $this->faker->generateSenderArray(),
        ]);

        self::assertInstanceOf(SenderCollection::class, $valueObject);
        self::assertCount(3, $valueObject);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument "senders.[0]" is not array');

        SenderCollection::fromArray([null], 'senders');
    }
}
