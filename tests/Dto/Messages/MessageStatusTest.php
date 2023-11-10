<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageStatus;
use Kholenkov\ProstorSmsSdk\ValueObject;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class MessageStatusTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new MessageStatus(
            $smscId = new ValueObject\MessageId($this->faker->faker->md5()),
            $status = ValueObject\MessageStatus::from($this->faker->randomMessageStatus()),
            $clientId = new ValueObject\MessageId($this->faker->faker->md5()),
        );

        self::assertSame($smscId, $valueObject->smscId);
        self::assertSame($status, $valueObject->status);
        self::assertSame($clientId, $valueObject->clientId);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($smscId, $array['smscId']);
        self::assertSame($status, $array['status']);
        self::assertSame($clientId, $array['clientId']);
    }

    public function testFromArray(): void
    {
        $valueObject = MessageStatus::fromArray([
            'smscId' => $smscId = $this->faker->faker->md5(),
            'status' => $status = $this->faker->randomMessageStatus(),
            'clientId' => $clientId = $this->faker->faker->md5(),
        ]);

        self::assertInstanceOf(MessageStatus::class, $valueObject);
        self::assertSame($smscId, (string) $valueObject->smscId);
        self::assertSame($status, $valueObject->status->value);
        self::assertSame($clientId, (string) $valueObject->clientId);
    }

    public function testFromArrayWithException1(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "messages.[0].smscId"');

        MessageStatus::fromArray(['smscId' => $this->faker->faker->uuid()], 'messages.[0]');
    }

    public function testFromArrayWithException2(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "messages.[0].status"');

        MessageStatus::fromArray(
            [
                'smscId' => $this->faker->faker->md5(),
                'status' => $this->faker->faker->md5(),
            ],
            'messages.[0]',
        );
    }

    public function testFromArrayWithException3(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "messages.[0].clientId"');

        MessageStatus::fromArray(
            [
                'smscId' => $this->faker->faker->md5(),
                'status' => $this->faker->randomMessageStatus(),
                'clientId' => $this->faker->faker->uuid(),
            ],
            'messages.[0]',
        );
    }
}
