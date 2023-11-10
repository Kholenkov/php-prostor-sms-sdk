<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Configuration;

use JsonSerializable;

final readonly class Configuration implements JsonSerializable
{
    public function __construct(
        public ApiAccess $apiAccess,
        public Logger $logger,
    ) {
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
