<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Helper;

use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Helper\ArrayHelper;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testGetArray(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->randomElements(),
            $this->faker->md5() => $this->faker->randomElements(),
            $this->faker->md5() => $this->faker->randomElements(),
        ];

        self::assertSame($expected, ArrayHelper::getArray($array, $key));
    }

    public function testGetArrayWhenNotArray(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not array', $keyForException));

        ArrayHelper::getArray([$key => $this->faker->md5()], $key, $keyForException);
    }

    public function testGetArrayWhenNotSet(): void
    {
        $key = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Invalid argument "%s"', $key));

        ArrayHelper::getArray([], $key);
    }

    public function testGetArrayNullable(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->randomElements(),
            $this->faker->md5() => $this->faker->randomElements(),
            $this->faker->md5() => $this->faker->randomElements(),
        ];

        self::assertSame($expected, ArrayHelper::getArrayNullable($array, $key));
    }

    public function testGetArrayNullableWhenNotArray(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not array', $keyForException));

        ArrayHelper::getArrayNullable([$key => $this->faker->md5()], $key, $keyForException);
    }

    public function testGetArrayNullableWillReturnDefault(): void
    {
        self::assertNull(ArrayHelper::getArrayNullable([], $this->faker->md5()));
    }

    public function testGetBool(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->boolean(),
            $this->faker->md5() => $this->faker->boolean(),
            $this->faker->md5() => $this->faker->boolean(),
        ];

        self::assertSame($expected, ArrayHelper::getBool($array, $key));
    }

    public function testGetBoolWhenNotBool(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not boolean', $keyForException));

        ArrayHelper::getBool([$key => $this->faker->md5()], $key, $keyForException);
    }

    public function testGetBoolWhenNotSet(): void
    {
        $key = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Invalid argument "%s"', $key));

        ArrayHelper::getBool([], $key);
    }

    public function testGetFloat(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->randomFloat(),
            $this->faker->md5() => $this->faker->randomFloat(),
            $this->faker->md5() => $this->faker->randomFloat(),
        ];

        self::assertSame($expected, ArrayHelper::getFloat($array, $key));
    }

    public function testGetFloatWhenNotFloat(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not number', $keyForException));

        ArrayHelper::getFloat([$key => $this->faker->md5()], $key, $keyForException);
    }

    public function testGetFloatWhenNotSet(): void
    {
        $key = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Invalid argument "%s"', $key));

        ArrayHelper::getFloat([], $key);
    }

    public function testGetFloatNullable(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->randomFloat(),
            $this->faker->md5() => $this->faker->randomFloat(),
            $this->faker->md5() => $this->faker->randomFloat(),
        ];

        self::assertSame($expected, ArrayHelper::getFloatNullable($array, $key));
    }

    public function testGetFloatNullableWhenNotFloat(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not number', $keyForException));

        ArrayHelper::getFloatNullable([$key => $this->faker->md5()], $key, $keyForException);
    }

    public function testGetFloatNullableWillReturnDefault(): void
    {
        self::assertNull(ArrayHelper::getFloatNullable([], $this->faker->md5()));
    }

    public function testGetInt(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->randomNumber(),
            $this->faker->md5() => $this->faker->randomNumber(),
            $this->faker->md5() => $this->faker->randomNumber(),
        ];

        self::assertSame($expected, ArrayHelper::getInt($array, $key));
    }

    public function testGetIntWhenNotInt(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not integer', $keyForException));

        ArrayHelper::getInt([$key => $this->faker->md5()], $key, $keyForException);
    }

    public function testGetIntWhenNotSet(): void
    {
        $key = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Invalid argument "%s"', $key));

        ArrayHelper::getInt([], $key);
    }

    public function testGetIntNullable(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->randomNumber(),
            $this->faker->md5() => $this->faker->randomNumber(),
            $this->faker->md5() => $this->faker->randomNumber(),
        ];

        self::assertSame($expected, ArrayHelper::getIntNullable($array, $key));
    }

    public function testGetIntNullableWhenNotInt(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not integer', $keyForException));

        ArrayHelper::getIntNullable([$key => $this->faker->md5()], $key, $keyForException);
    }

    public function testGetIntNullableWillReturnDefault(): void
    {
        self::assertNull(ArrayHelper::getIntNullable([], $this->faker->md5()));
    }

    public function testGetString(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->md5(),
            $this->faker->md5() => $this->faker->md5(),
            $this->faker->md5() => $this->faker->md5(),
        ];

        self::assertSame($expected, ArrayHelper::getString($array, $key));
    }

    public function testGetStringWhenNotSet(): void
    {
        $key = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Invalid argument "%s"', $key));

        ArrayHelper::getString([], $key);
    }

    public function testGetStringWhenNotString(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not string', $keyForException));

        ArrayHelper::getString([$key => $this->faker->boolean()], $key, $keyForException);
    }

    public function testGetStringNullable(): void
    {
        $array = [
            $key = $this->faker->md5() => $expected = $this->faker->md5(),
            $this->faker->md5() => $this->faker->md5(),
            $this->faker->md5() => $this->faker->md5(),
        ];

        self::assertSame($expected, ArrayHelper::getStringNullable($array, $key));
    }

    public function testGetStringNullableWhenNotString(): void
    {
        $key = $this->faker->md5();
        $keyForException = $this->faker->md5();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Argument "%s" is not string', $keyForException));

        ArrayHelper::getStringNullable([$key => $this->faker->boolean()], $key, $keyForException);
    }

    public function testGetStringNullableWillReturnDefault(): void
    {
        self::assertNull(ArrayHelper::getStringNullable([], $this->faker->md5()));
    }
}
