<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Configuration;

use Faker\Factory;
use Faker\Generator;
use Kholenkov\ProstorSmsSdk\Configuration\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testConstruct(): void
    {
        $object = new Logger(
            $isEnabled = $this->faker->boolean(),
            $isLogApiAccess = $this->faker->boolean(),
            $messagePrefix = $this->faker->md5(),
        );

        self::assertSame($isEnabled, $object->isEnabled);
        self::assertSame($isLogApiAccess, $object->isLogApiAccess);
        self::assertSame($messagePrefix, $object->messagePrefix);


        $array = $object->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($isEnabled, $array['isEnabled']);
        self::assertSame($isLogApiAccess, $array['isLogApiAccess']);
        self::assertSame($messagePrefix, $array['messagePrefix']);
    }

    public function testGenerateMessage(): void
    {
        $object = new Logger(
            false,
            false,
            $messagePrefix = $this->faker->md5(),
        );

        $message = $this->faker->md5();

        self::assertSame($object->generateMessage($message), "{$messagePrefix}{$message}");
    }
}
