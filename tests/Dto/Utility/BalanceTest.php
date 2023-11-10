<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Utility\Balance;
use Kholenkov\ProstorSmsSdk\ValueObject\BalanceType;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class BalanceTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new Balance(
            $type = BalanceType::from($this->faker->randomBalanceType()),
            $balance = $this->faker->faker->randomFloat(),
            $credit = $this->faker->faker->randomFloat(),
        );

        self::assertSame($type, $valueObject->type);
        self::assertSame($balance, $valueObject->balance);
        self::assertSame($credit, $valueObject->credit);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($type, $array['type']);
        self::assertSame($balance, $array['balance']);
        self::assertSame($credit, $array['credit']);
    }

    public function testFromArray(): void
    {
        $valueObject = Balance::fromArray([
            'type' => $type = $this->faker->randomBalanceType(),
            'balance' => $balance = $this->faker->faker->randomFloat(),
            'credit' => $credit = $this->faker->faker->randomFloat(),
        ]);

        self::assertInstanceOf(Balance::class, $valueObject);
        self::assertSame($type, $valueObject->type->value);
        self::assertSame($balance, $valueObject->balance);
        self::assertSame($credit, $valueObject->credit);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "balance.[0].type"');

        Balance::fromArray(['type' => $this->faker->faker->md5()], 'balance.[0]');
    }
}
