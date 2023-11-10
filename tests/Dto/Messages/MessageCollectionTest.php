<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use Kholenkov\ProstorSmsSdk\Dto\Messages\Message;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageCollection;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class MessageCollectionTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $values = [
            $this->faker->generateMessageObject(),
            $this->faker->generateMessageObject(),
            $this->faker->generateMessageObject(),
        ];


        $valueObject = new MessageCollection(...$values);

        self::assertCount(3, $valueObject);

        foreach ($valueObject as $key => $value) {
            self::assertInstanceOf(Message::class, $value);
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
}
