<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use Kholenkov\ProstorSmsSdk\ValueObject\SenderStatus;
use PHPUnit\Framework\TestCase;

class SenderStatusTest extends TestCase
{
    public function testValues(): void
    {
        self::assertSame('active', SenderStatus::Active->value);
        self::assertSame('blocked', SenderStatus::Blocked->value);
        self::assertSame('default', SenderStatus::Default->value);
        self::assertSame('new', SenderStatus::New->value);
        self::assertSame('pending', SenderStatus::Pending->value);
    }
}
