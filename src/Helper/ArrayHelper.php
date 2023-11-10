<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Helper;

use InvalidArgumentException;

class ArrayHelper
{
    public static function getArray(
        array $array,
        string $key,
        ?string $keyForException = null
    ): array {
        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!isset($array[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument "%s"', $keyForException));
        } elseif (!is_array($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not array', $keyForException));
        }

        return $array[$key];
    }

    public static function getArrayNullable(
        array $array,
        string $key,
        ?string $keyForException = null,
        ?array $default = null
    ): ?array {
        if (!isset($array[$key])) {
            return $default;
        }

        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!is_array($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not array', $keyForException));
        }

        return $array[$key];
    }

    public static function getBool(
        array $array,
        string $key,
        ?string $keyForException = null
    ): bool {
        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!isset($array[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument "%s"', $keyForException));
        } elseif (!is_bool($array[$key]) && !is_numeric($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not boolean', $keyForException));
        }

        return (bool) $array[$key];
    }

    public static function getFloat(
        array $array,
        string $key,
        ?string $keyForException = null
    ): float {
        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!isset($array[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument "%s"', $keyForException));
        } elseif (!is_numeric($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not number', $keyForException));
        }

        return (float) $array[$key];
    }

    public static function getFloatNullable(
        array $array,
        string $key,
        ?string $keyForException = null,
        ?float $default = null
    ): ?float {
        if (!isset($array[$key])) {
            return $default;
        }

        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!is_numeric($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not number', $keyForException));
        }

        return (float) $array[$key];
    }

    public static function getInt(
        array $array,
        string $key,
        ?string $keyForException = null
    ): int {
        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!isset($array[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument "%s"', $keyForException));
        } elseif (!is_numeric($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not integer', $keyForException));
        }

        return (int) $array[$key];
    }

    public static function getIntNullable(
        array $array,
        string $key,
        ?string $keyForException = null,
        ?int $default = null
    ): ?int {
        if (!isset($array[$key])) {
            return $default;
        }

        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!is_numeric($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not integer', $keyForException));
        }

        return (int) $array[$key];
    }

    public static function getString(
        array $array,
        string $key,
        ?string $keyForException = null
    ): string {
        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!isset($array[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument "%s"', $keyForException));
        } elseif (!is_string($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not string', $keyForException));
        }

        return $array[$key];
    }

    public static function getStringNullable(
        array $array,
        string $key,
        ?string $keyForException = null,
        ?string $default = null
    ): ?string {
        if (!isset($array[$key])) {
            return $default;
        }

        if (null === $keyForException) {
            $keyForException = $key;
        }

        if (!is_string($array[$key])) {
            throw new InvalidArgumentException(sprintf('Argument "%s" is not string', $keyForException));
        }

        return $array[$key];
    }
}
