<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Messages;

use JsonSerializable;

final readonly class GetStatusRequest implements JsonSerializable
{
    public function __construct(public MessageIdCollection $messages)
    {
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public function toArray(): array
    {
        return ['messages' => $this->messages->toArray()];
    }
}
