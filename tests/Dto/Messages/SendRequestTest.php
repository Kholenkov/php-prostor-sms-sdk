<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use DateTimeInterface;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageCollection;
use Kholenkov\ProstorSmsSdk\Dto\Messages\SendRequest;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatusQueueName;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class SendRequestTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new SendRequest(
            $messages = new MessageCollection($this->faker->generateMessageObject()),
            $statusQueueName = new MessageStatusQueueName($this->faker->randomString(3, 16)),
            $scheduleTime = $this->faker->faker->dateTime(),
            $showBillingDetails = $this->faker->faker->boolean(),
        );

        self::assertSame($messages, $valueObject->messages);
        self::assertSame($statusQueueName, $valueObject->statusQueueName);
        self::assertSame($scheduleTime, $valueObject->scheduleTime);
        self::assertSame($showBillingDetails, $valueObject->showBillingDetails);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($messages, $array['messages']);
        self::assertSame($statusQueueName, $array['statusQueueName']);
        self::assertSame($scheduleTime, $array['scheduleTime']);
        self::assertSame($showBillingDetails, $array['showBillingDetails']);


        $array = $valueObject->toArray();

        self::assertIsArray($array);
        self::assertSame($messages->toArray(), $array['messages']);
        self::assertSame((string) $statusQueueName, $array['statusQueueName']);
        self::assertSame($scheduleTime->format(DateTimeInterface::RFC3339), $array['scheduleTime']);
        self::assertSame($showBillingDetails, $array['showBillingDetails']);
    }
}
