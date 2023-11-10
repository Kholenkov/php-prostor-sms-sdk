<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatus;
use PHPUnit\Framework\TestCase;

class MessageStatusTest extends TestCase
{
    public function testValues(): void
    {
        self::assertSame('accepted', MessageStatus::Accepted->value);
        self::assertSame('delivered', MessageStatus::Delivered->value);
        self::assertSame('delivery error', MessageStatus::DeliveryError->value);
        self::assertSame('text is empty', MessageStatus::EmptyText->value);
        self::assertSame('incorrect id', MessageStatus::IncorrectId->value);
        self::assertSame('invalid mobile phone', MessageStatus::InvalidPhoneNumber->value);
        self::assertSame('invalid schedule time format', MessageStatus::InvalidScheduleTimeFormat->value);
        self::assertSame('sender address invalid', MessageStatus::InvalidSenderName->value);
        self::assertSame('invalid status queue name', MessageStatus::InvalidStatusQueueName->value);
        self::assertSame('wapurl invalid', MessageStatus::InvalidWapUrl->value);
        self::assertSame('not enough balance', MessageStatus::NotEnoughBalance->value);
        self::assertSame('queued', MessageStatus::Queued->value);
        self::assertSame('smsc submit', MessageStatus::SmscDelivered->value);
        self::assertSame('smsc reject', MessageStatus::SmscRejected->value);
    }
}
