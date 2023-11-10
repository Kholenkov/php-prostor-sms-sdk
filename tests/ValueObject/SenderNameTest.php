<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\ValueObject\SenderName;
use PHPUnit\Framework\TestCase;

class SenderNameTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testConstruct(): void
    {
        $valueObject = new SenderName($value = $this->faker->md5());

        self::assertSame($value, (string) $valueObject);
        self::assertSame(json_encode($value), json_encode($valueObject));
    }

    public function testConstructWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty sender name');

        new SenderName('');
    }

    public function testConstructWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid sender name');

        new SenderName(str_repeat('a', 300));
    }

    public function testIsValid(): void
    {
        self::assertTrue(SenderName::isValid($this->faker->md5()));
        self::assertFalse(SenderName::isValid(''));
        self::assertFalse(SenderName::isValid(str_repeat('a', 300)));
    }
}
