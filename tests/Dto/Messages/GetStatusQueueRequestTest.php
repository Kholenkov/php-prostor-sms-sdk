<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusQueueRequest;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatusQueueLimit;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatusQueueName;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class GetStatusQueueRequestTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new GetStatusQueueRequest(
            $statusQueueName = new MessageStatusQueueName($this->faker->randomString(3, 16)),
            $statusQueueLimit = new MessageStatusQueueLimit($this->faker->faker->randomDigitNotZero()),
        );

        self::assertSame($statusQueueName, $valueObject->statusQueueName);
        self::assertSame($statusQueueLimit, $valueObject->statusQueueLimit);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($statusQueueName, $array['statusQueueName']);
        self::assertSame($statusQueueLimit, $array['statusQueueLimit']);


        $array = $valueObject->toArray();

        self::assertIsArray($array);
        self::assertSame((string) $statusQueueName, $array['statusQueueName']);
        self::assertSame($statusQueueLimit->toInt(), $array['statusQueueLimit']);
    }
}
