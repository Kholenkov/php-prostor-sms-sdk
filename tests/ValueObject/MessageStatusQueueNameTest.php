<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatusQueueName;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class MessageStatusQueueNameTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new MessageStatusQueueName($value = $this->faker->randomString(3, 16));

        self::assertSame($value, (string) $valueObject);
        self::assertSame(json_encode($value), json_encode($valueObject));
    }

    public function testConstructWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty message status queue name');

        new MessageStatusQueueName('');
    }

    public function testConstructWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid message status queue name');

        new MessageStatusQueueName($this->faker->faker->md5());
    }

    public function testIsValid(): void
    {
        self::assertTrue(MessageStatusQueueName::isValid($this->faker->randomString(3, 16)));
        self::assertFalse(MessageStatusQueueName::isValid(''));
        self::assertFalse(MessageStatusQueueName::isValid($this->faker->faker->md5()));
    }
}
