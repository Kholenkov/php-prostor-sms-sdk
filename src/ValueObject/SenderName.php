<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

use InvalidArgumentException;
use JsonSerializable;

final readonly class SenderName implements JsonSerializable
{
    public function __construct(private string $value)
    {
        if (!$value) {
            throw new InvalidArgumentException('Empty sender name');
        } elseif (!self::isValid($value)) {
            throw new InvalidArgumentException('Invalid sender name');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function isValid(string $value): bool
    {
        return (bool) preg_match('/^[0-9a-z\s]{1,255}$/i', $value);
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }
}
