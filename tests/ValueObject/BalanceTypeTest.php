<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use Kholenkov\ProstorSmsSdk\ValueObject\BalanceType;
use PHPUnit\Framework\TestCase;

class BalanceTypeTest extends TestCase
{
    public function testValues(): void
    {
        self::assertSame('RUB', BalanceType::Rub->value);
        self::assertSame('SMS', BalanceType::Sms->value);
    }
}
