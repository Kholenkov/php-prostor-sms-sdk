<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use JsonSerializable;
use Kholenkov\ProstorSmsSdk\Helper\ArrayHelper;
use Kholenkov\ProstorSmsSdk\ValueObject\SenderName;
use Kholenkov\ProstorSmsSdk\ValueObject\SenderStatus;

final readonly class Sender implements JsonSerializable
{
    public function __construct(
        public SenderName $name,
        public SenderStatus $status,
        public string $info = '',
    ) {
    }

    public static function fromArray(array $array, string $keyForException = ''): self
    {
        if ($keyForException) {
            $keyForException .= '.';
        }

        $statusValue = ArrayHelper::getString($array, 'status', "{$keyForException}status");
        $status = SenderStatus::tryFrom($statusValue);
        if (null === $status) {
            throw new InvalidArgumentException(
                sprintf('Invalid argument "%s"', "{$keyForException}status")
            );
        }

        return new self(
            new SenderName(ArrayHelper::getString($array, 'name', "{$keyForException}name")),
            $status,
            ArrayHelper::getString($array, 'info', "{$keyForException}info"),
        );
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
