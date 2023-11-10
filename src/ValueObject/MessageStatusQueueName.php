<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

use InvalidArgumentException;
use JsonSerializable;

final readonly class MessageStatusQueueName implements JsonSerializable
{
    public function __construct(private string $value)
    {
        if (!$value) {
            throw new InvalidArgumentException('Empty message status queue name');
        } elseif (!self::isValid($value)) {
            throw new InvalidArgumentException('Invalid message status queue name');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function isValid(string $value): bool
    {
        return (bool) preg_match('/^[0-9a-z]{3,16}$/i', $value);
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
