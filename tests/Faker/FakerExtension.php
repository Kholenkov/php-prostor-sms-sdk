<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Faker;

use Faker\Factory;
use Faker\Generator;
use Kholenkov\ProstorSmsSdk\Dto\Messages\Message;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageId;
use Kholenkov\ProstorSmsSdk\Dto\Messages\MessageStatus;
use Kholenkov\ProstorSmsSdk\Dto\Utility\Balance;
use Kholenkov\ProstorSmsSdk\Dto\Utility\Sender;
use Kholenkov\ProstorSmsSdk\ValueObject;

class FakerExtension
{
    public Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function generateBalanceArray(): array
    {
        return [
            'type' => $this->randomBalanceType(),
            'balance' => $this->faker->randomFloat(),
            'credit' => $this->faker->randomFloat(),
        ];
    }

    public function generateBalanceObject(): Balance
    {
        return new Balance(
            ValueObject\BalanceType::from($this->randomBalanceType()),
            $this->faker->randomFloat(),
            $this->faker->randomFloat(),
        );
    }

    public function generateMessageIdArray(): array
    {
        return [
            'smscId' => $this->faker->md5(),
            'clientId' => $this->faker->md5(),
        ];
    }

    public function generateMessageIdObject(): MessageId
    {
        return new MessageId(
            new ValueObject\MessageId($this->faker->md5()),
            new ValueObject\MessageId($this->faker->md5()),
        );
    }

    public function generateMessageObject(): Message
    {
        return new Message(
            new ValueObject\MessageId($this->faker->md5()),
            new ValueObject\PhoneNumber($this->randomPhoneNumber()),
            $this->faker->realText(),
            new ValueObject\SenderName($this->faker->md5()),
        );
    }

    public function generateMessageStatusArray(): array
    {
        return [
            'smscId' => $this->faker->md5(),
            'status' => $this->randomMessageStatus(),
            'clientId' => $this->faker->md5(),
        ];
    }

    public function generateMessageStatusObject(): MessageStatus
    {
        return new MessageStatus(
            new ValueObject\MessageId($this->faker->md5()),
            ValueObject\MessageStatus::from($this->randomMessageStatus()),
            new ValueObject\MessageId($this->faker->md5()),
        );
    }

    public function generateSenderArray(): array
    {
        return [
            'name' => $this->faker->md5(),
            'status' => $this->randomSenderStatus(),
            'info' => $this->faker->md5(),
        ];
    }

    public function generateSenderObject(): Sender
    {
        return new Sender(
            new ValueObject\SenderName($this->faker->md5()),
            ValueObject\SenderStatus::from($this->randomSenderStatus()),
            $this->faker->md5(),
        );
    }

    public function randomBalanceType(): string
    {
        return $this->faker->randomElement(['RUB', 'SMS']);
    }

    public function randomMessageStatus(): string
    {
        return $this->faker->randomElement([
            'accepted',
            'delivered',
            'delivery error',
            'incorrect id',
            'invalid mobile phone',
            'invalid schedule time format',
            'invalid status queue name',
            'not enough balance',
            'sender address invalid',
            'smsc reject',
            'smsc submit',
            'text is empty',
            'wapurl invalid',
        ]);
    }

    public function randomPhoneNumber(): string
    {
        return '+7'
            . $this->faker->randomNumber(3, true)
            . $this->faker->randomNumber(7, true);
    }

    public function randomResponseStatus(): string
    {
        return $this->faker->randomElement(['error', 'ok']);
    }

    public function randomSenderStatus(): string
    {
        return $this->faker->randomElement(['active', 'blocked', 'default', 'new', 'pending']);
    }

    public function randomString(
        int $minLength = 0,
        int $maxLength = 255,
        string $symbols = '0123456789abcdefghijklmnopqrstuvwxyz',
    ): string {
        if ($minLength < 0) {
            $minLength = 0;
        }
        if (255 < $maxLength) {
            $maxLength = 255;
        }
        $symbolsLength = strlen($symbols);

        $result = '';
        for ($i = $minLength; $i < $maxLength; $i++) {
            $result .= $symbols[mt_rand(1, $symbolsLength) - 1];
        }

        return $result;
    }
}
