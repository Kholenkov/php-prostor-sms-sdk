<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\ValueObject;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\ValueObject\PhoneNumber;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new PhoneNumber($value = $this->faker->randomPhoneNumber());

        self::assertSame($value, (string) $valueObject);
        self::assertSame(json_encode($value), json_encode($valueObject));
    }

    public function testConstructWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty phone number');

        new PhoneNumber('');
    }

    public function testConstructWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid phone number');

        new PhoneNumber($this->faker->faker->md5());
    }

    public function testIsValid(): void
    {
        self::assertTrue(PhoneNumber::isValid($this->faker->randomPhoneNumber()));
        self::assertFalse(PhoneNumber::isValid(''));
        self::assertFalse(PhoneNumber::isValid($this->faker->faker->md5()));
    }
}
