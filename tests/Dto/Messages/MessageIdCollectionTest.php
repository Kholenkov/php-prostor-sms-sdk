<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageId;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageIdCollection;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class MessageIdCollectionTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $values = [
            $this->faker->generateMessageIdObject(),
            $this->faker->generateMessageIdObject(),
            $this->faker->generateMessageIdObject(),
        ];


        $valueObject = new MessageIdCollection(...$values);

        self::assertCount(3, $valueObject);

        foreach ($valueObject as $key => $value) {
            self::assertInstanceOf(MessageId::class, $value);
            self::assertSame($values[$key], $value);
        }


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertCount(3, $array);

        foreach ($array as $key => $value) {
            self::assertIsArray($value);
            self::assertSame($values[$key]->jsonSerialize(), $value);
        }


        $array = $valueObject->toArray();

        self::assertIsArray($array);
        self::assertCount(3, $array);

        foreach ($array as $key => $value) {
            self::assertIsArray($value);
            self::assertSame($values[$key]->toArray(), $value);
        }
    }

    public function testFromArray(): void
    {
        $valueObject = MessageIdCollection::fromArray([
            $this->faker->generateMessageIdArray(),
            $this->faker->generateMessageIdArray(),
            $this->faker->generateMessageIdArray(),
        ]);

        self::assertInstanceOf(MessageIdCollection::class, $valueObject);
        self::assertCount(3, $valueObject);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument "messages.[0]" is not array');

        MessageIdCollection::fromArray([null], 'messages');
    }
}
