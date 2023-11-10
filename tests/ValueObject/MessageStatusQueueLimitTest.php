<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatusQueueLimit;
use PHPUnit\Framework\TestCase;

class MessageStatusQueueLimitTest extends TestCase
{
    public function testConstruct(): void
    {
        $valueObject = new MessageStatusQueueLimit($value = mt_rand(1, 1000));

        self::assertSame($value, $valueObject->toInt());
        self::assertSame(json_encode($value), json_encode($valueObject));
    }

    public function testConstructWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid message status queue limit');

        new MessageStatusQueueLimit(0);
    }

    public function testIsValid(): void
    {
        self::assertTrue(MessageStatusQueueLimit::isValid(mt_rand(1, 1000)));
        self::assertFalse(MessageStatusQueueLimit::isValid(-1));
        self::assertFalse(MessageStatusQueueLimit::isValid(0));
        self::assertFalse(MessageStatusQueueLimit::isValid(mt_rand(1001, 10000)));
    }
}
