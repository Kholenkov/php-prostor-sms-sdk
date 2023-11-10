<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageId;
use Kholenkov\ProstorSmsSdk\ValueObject;
use PHPUnit\Framework\TestCase;

class MessageIdTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testConstruct(): void
    {
        $valueObject = new MessageId(
            $smscId = new ValueObject\MessageId($this->faker->md5()),
            $clientId = new ValueObject\MessageId($this->faker->md5()),
        );

        self::assertSame($smscId, $valueObject->smscId);
        self::assertSame($clientId, $valueObject->clientId);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($smscId, $array['smscId']);
        self::assertSame($clientId, $array['clientId']);


        $array = $valueObject->toArray();

        self::assertIsArray($array);
        self::assertSame((string) $smscId, $array['smscId']);
        self::assertSame((string) $clientId, $array['clientId']);
    }

    public function testFromArray(): void
    {
        $valueObject = MessageId::fromArray([
            'smscId' => $smscId = $this->faker->md5(),
            'clientId' => $clientId = $this->faker->md5(),
        ]);

        self::assertInstanceOf(MessageId::class, $valueObject);
        self::assertSame($smscId, (string) $valueObject->smscId);
        self::assertSame($clientId, (string) $valueObject->clientId);
    }

    public function testFromArrayWithException1(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "messages.[0].smscId"');

        MessageId::fromArray(['smscId' => $this->faker->uuid()], 'messages.[0]');
    }

    public function testFromArrayWithException2(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "messages.[0].clientId"');

        MessageId::fromArray(
            [
                'smscId' => $this->faker->md5(),
                'clientId' => $this->faker->uuid(),
            ],
            'messages.[0]',
        );
    }
}
