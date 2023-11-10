<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Messages;

use InvalidArgumentException;
use JsonSerializable;
use Kholenkov\ProstorSmsSdk\Helper\ArrayHelper;
use Kholenkov\ProstorSmsSdk\ValueObject;

final readonly class MessageId implements JsonSerializable
{
    public function __construct(
        public ValueObject\MessageId $smscId,
        public ?ValueObject\MessageId $clientId = null,
    ) {
    }

    public static function fromArray(array $array, string $keyForException = ''): self
    {
        if ($keyForException) {
            $keyForException .= '.';
        }

        $smscIdValue = ArrayHelper::getString($array, 'smscId', "{$keyForException}smscId");
        if (!ValueObject\MessageId::isValid($smscIdValue)) {
            throw new InvalidArgumentException(
                sprintf('Invalid argument "%s"', "{$keyForException}smscId")
            );
        }

        $clientIdValue = ArrayHelper::getStringNullable($array, 'clientId', "{$keyForException}clientId");
        if (null !== $clientIdValue && !ValueObject\MessageId::isValid($clientIdValue)) {
            throw new InvalidArgumentException(
                sprintf('Invalid argument "%s"', "{$keyForException}clientId")
            );
        }

        return new self(
            new ValueObject\MessageId($smscIdValue),
            null !== $clientIdValue ? new ValueObject\MessageId($clientIdValue) : null,
        );
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public function toArray(): array
    {
        $array = ['smscId' => (string) $this->smscId];

        if (null !== $this->clientId) {
            $array['clientId'] = (string) $this->clientId;
        }

        return $array;
    }
}
