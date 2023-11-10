<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use Kholenkov\ProstorSmsSdk\Dto\Messages\Message;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageId;
use Kholenkov\ProstorSmsSdk\ValueObject\PhoneNumber;
use Kholenkov\ProstorSmsSdk\ValueObject\SenderName;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new Message(
            $clientId = new MessageId($this->faker->faker->md5()),
            $phone = new PhoneNumber($this->faker->randomPhoneNumber()),
            $text = $this->faker->faker->realText(),
            $sender = new SenderName($this->faker->faker->md5()),
        );

        self::assertSame($clientId, $valueObject->clientId);
        self::assertSame($phone, $valueObject->phone);
        self::assertSame($text, $valueObject->text);
        self::assertSame($sender, $valueObject->sender);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($clientId, $array['clientId']);
        self::assertSame($phone, $array['phone']);
        self::assertSame($text, $array['text']);
        self::assertSame($sender, $array['sender']);


        $array = $valueObject->toArray();

        self::assertIsArray($array);
        self::assertSame((string) $clientId, $array['clientId']);
        self::assertSame((string) $phone, $array['phone']);
        self::assertSame($text, $array['text']);
        self::assertSame((string) $sender, $array['sender']);
    }
}
