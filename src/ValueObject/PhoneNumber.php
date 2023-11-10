<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

use InvalidArgumentException;
use JsonSerializable;

final readonly class PhoneNumber implements JsonSerializable
{
    public function __construct(private string $value)
    {
        if (!$value) {
            throw new InvalidArgumentException('Empty phone number');
        } elseif (!self::isValid($value)) {
            throw new InvalidArgumentException('Invalid phone number');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function isValid(string $value): bool
    {
        return (bool) preg_match('/^\+7([0-9]{10})$/i', $value);
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
