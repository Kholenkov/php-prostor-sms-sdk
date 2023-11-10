<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use Kholenkov\ProstorSmsSdk\ValueObject\ResponseStatus;
use PHPUnit\Framework\TestCase;

class ResponseStatusTest extends TestCase
{
    public function testValues(): void
    {
        self::assertSame('error', ResponseStatus::Error->value);
        self::assertSame('ok', ResponseStatus::Ok->value);
    }
}
