<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageId;
use PHPUnit\Framework\TestCase;

class MessageIdTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testConstruct(): void
    {
        $valueObject = new MessageId($value = $this->faker->md5());

        self::assertSame($value, (string) $valueObject);
        self::assertSame(json_encode($value), json_encode($valueObject));
    }

    public function testConstructWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty message id');

        new MessageId('');
    }

    public function testConstructWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid message id');

        new MessageId($this->faker->uuid());
    }

    public function testIsValid(): void
    {
        self::assertTrue(MessageId::isValid($this->faker->md5()));
        self::assertFalse(MessageId::isValid(''));
        self::assertFalse(MessageId::isValid($this->faker->uuid()));
    }
}
