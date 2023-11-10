<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use JsonSerializable;
use Kholenkov\ProstorSmsSdk\Helper\ArrayHelper;
use Kholenkov\ProstorSmsSdk\ValueObject\BalanceType;

final readonly class Balance implements JsonSerializable
{
    public function __construct(
        public BalanceType $type,
        public float $balance,
        public float $credit,
    ) {
    }

    public static function fromArray(array $array, string $keyForException = ''): self
    {
        if ($keyForException) {
            $keyForException .= '.';
        }

        $typeValue = ArrayHelper::getString($array, 'type', "{$keyForException}type");
        $type = BalanceType::tryFrom($typeValue);
        if (null === $type) {
            throw new InvalidArgumentException(
                sprintf('Invalid argument "%s"', "{$keyForException}type")
            );
        }

        return new self(
            $type,
            ArrayHelper::getFloat($array, 'balance', "{$keyForException}balance"),
            ArrayHelper::getFloat($array, 'credit', "{$keyForException}credit"),
        );
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
