<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageStatus;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageStatusCollection;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class MessageStatusCollectionTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $values = [
            $this->faker->generateMessageStatusObject(),
            $this->faker->generateMessageStatusObject(),
            $this->faker->generateMessageStatusObject(),
        ];


        $valueObject = new MessageStatusCollection(...$values);

        self::assertCount(3, $valueObject);

        foreach ($valueObject as $key => $value) {
            self::assertInstanceOf(MessageStatus::class, $value);
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
        $valueObject = MessageStatusCollection::fromArray([
            $this->faker->generateMessageStatusArray(),
            $this->faker->generateMessageStatusArray(),
            $this->faker->generateMessageStatusArray(),
        ]);

        self::assertInstanceOf(MessageStatusCollection::class, $valueObject);
        self::assertCount(3, $valueObject);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument "messages.[0]" is not array');

        MessageStatusCollection::fromArray([null], 'messages');
    }
}
