<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Dto\Messages;

use InvalidArgumentException;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageStatusCollection;
use Kholenkov\ProstorSmsSdk\Dto\Messages\SendResponse;
use Kholenkov\ProstorSmsSdk\Dto\Utility\BalanceCollection;
use Kholenkov\ProstorSmsSdk\ValueObject\ResponseStatus;
use KholenkovTest\ProstorSmsSdk\Faker\FakerExtension;
use PHPUnit\Framework\TestCase;

class SendResponseTest extends TestCase
{
    private FakerExtension $faker;

    protected function setUp(): void
    {
        $this->faker = new FakerExtension();
    }

    public function testConstruct(): void
    {
        $valueObject = new SendResponse(
            $httpStatusCode = $this->faker->faker->randomElement([200, 400]),
            $status = ResponseStatus::from($this->faker->randomResponseStatus()),
            $messages = new MessageStatusCollection($this->faker->generateMessageStatusObject()),
            $smsCount = $this->faker->faker->randomNumber(),
            $msgCost = $this->faker->faker->randomFloat(),
            $balance = new BalanceCollection($this->faker->generateBalanceObject()),
            $description = $this->faker->faker->realText(),
        );

        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status);
        self::assertSame($messages, $valueObject->messages);
        self::assertSame($smsCount, $valueObject->smsCount);
        self::assertSame($msgCost, $valueObject->msgCost);
        self::assertSame($balance, $valueObject->balance);
        self::assertSame($description, $valueObject->description);


        $array = $valueObject->jsonSerialize();

        self::assertIsArray($array);
        self::assertSame($httpStatusCode, $array['httpStatusCode']);
        self::assertSame($status, $array['status']);
        self::assertSame($messages, $array['messages']);
        self::assertSame($smsCount, $array['smsCount']);
        self::assertSame($msgCost, $array['msgCost']);
        self::assertSame($balance, $array['balance']);
        self::assertSame($description, $array['description']);
    }

    public function testFromArrayWhenError(): void
    {
        $valueObject = SendResponse::fromArray(
            $httpStatusCode = 400,
            [
                'status' => $status = 'error',
                'description' => $description = $this->faker->faker->md5(),
            ],
        );

        self::assertInstanceOf(SendResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertNull($valueObject->messages);
        self::assertNull($valueObject->smsCount);
        self::assertNull($valueObject->msgCost);
        self::assertNull($valueObject->balance);
        self::assertSame($description, $valueObject->description);
    }

    public function testFromArrayWhenOk(): void
    {
        $valueObject = SendResponse::fromArray(
            $httpStatusCode = 200,
            [
                'status' => $status = 'ok',
                'messages' => $messages = [$this->faker->generateMessageStatusArray()],
                'smsCount' => $smsCount = $this->faker->faker->randomNumber(),
                'msgCost' => $msgCost = $this->faker->faker->randomFloat(),
                'balance' => $balance = [$this->faker->generateBalanceArray()],
            ],
        );

        self::assertInstanceOf(SendResponse::class, $valueObject);
        self::assertSame($httpStatusCode, $valueObject->httpStatusCode);
        self::assertSame($status, $valueObject->status->value);
        self::assertSame(json_encode($messages), json_encode($valueObject->messages));
        self::assertSame($smsCount, $valueObject->smsCount);
        self::assertSame($msgCost, $valueObject->msgCost);
        self::assertSame(json_encode($balance), json_encode($valueObject->balance));
        self::assertNull($valueObject->description);
    }

    public function testFromArrayWithException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid argument "status"');

        SendResponse::fromArray(200, ['status' => $this->faker->faker->md5()]);
    }
}
