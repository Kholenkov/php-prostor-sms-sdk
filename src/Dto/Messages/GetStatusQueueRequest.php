<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Messages;

use JsonSerializable;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatusQueueLimit;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatusQueueName;

final readonly class GetStatusQueueRequest implements JsonSerializable
{
    public function __construct(
        public MessageStatusQueueName $statusQueueName,
        public MessageStatusQueueLimit $statusQueueLimit = new MessageStatusQueueLimit(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public function toArray(): array
    {
        return [
            'statusQueueName' => (string) $this->statusQueueName,
            'statusQueueLimit' => $this->statusQueueLimit->toInt(),
        ];
    }
}
