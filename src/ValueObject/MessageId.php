<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

use InvalidArgumentException;
use JsonSerializable;

final readonly class MessageId implements JsonSerializable
{
    public function __construct(private string $value)
    {
        if (!$value) {
            throw new InvalidArgumentException('Empty message id');
        } elseif (!self::isValid($value)) {
            throw new InvalidArgumentException('Invalid message id');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function isValid(string $value): bool
    {
        return (bool) preg_match('/^[0-9a-f]{1,72}$/i', $value);
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
