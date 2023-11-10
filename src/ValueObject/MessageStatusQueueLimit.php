<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

use InvalidArgumentException;
use JsonSerializable;

final readonly class MessageStatusQueueLimit implements JsonSerializable
{
    public function __construct(private int $value = 1)
    {
        if (!self::isValid($value)) {
            throw new InvalidArgumentException('Invalid message status queue limit');
        }
    }

    public static function isValid(int $value): bool
    {
        return 0 < $value && $value <= 1000;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }

    public function toInt(): int
    {
        return $this->value;
    }
}
