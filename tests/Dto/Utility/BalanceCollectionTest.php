<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Utility\Balance;
use Kholenkov\ProstorSmsSdk\Dto\Utility\BalanceCollection;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class BalanceCollectionTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $values = [
            $this->faker->generateBalanceObject(),
            $this->faker->generateBalanceObject(),
            $this->faker->generateBalanceObject(),
        ];


        $valueObject = new BalanceCollection(...$values);

        self::assertCount(3, $valueObject);

        foreach ($valueObject as $key => $value) {
            self::assertInstanceOf(Balance::class, $value);
            self::assertSame($values[$key], $value);
        }


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertCount(3, $array);

        foreach ($array as $key => $value) {
            self::assertIsArray($value);
            self::assertSame($values[$key]->jsonSerialize(), $value);
        }
    }

    public function testFromArray(): void
    {
        $valueObject = BalanceCollection::fromArray([
            $this->faker->generateBalanceArray(),
            $this->faker->generateBalanceArray(),
            $this->faker->generateBalanceArray(),
        ]);

        self::assertInstanceOf(BalanceCollection::class, $valueObject);
        self::assertCount(3, $valueObject);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument "balance.[0]" is not array');

        BalanceCollection::fromArray([null], 'balance');
    }
}
