<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Configuration;

use JsonSerializable;

final readonly class Logger implements JsonSerializable
{
    public function __construct(
        public bool $isEnabled = false,
        public bool $isLogApiAccess = false,
        public string $messagePrefix = 'prostor_sms_sdk__',
    ) {
    }

    public function generateMessage(string $message): string
    {
        return $this->messagePrefix . $message;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
