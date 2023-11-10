<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageIdCollection;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class GetStatusRequestTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new GetStatusRequest(
            $messages = new MessageIdCollection($this->faker->generateMessageIdObject()),
        );

        self::assertSame($messages, $valueObject->messages);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($messages, $array['messages']);


        $array = $valueObject->toArray();

        self::assertIsArray($array);
        self::assertSame($messages->toArray(), $array['messages']);
    }
}
