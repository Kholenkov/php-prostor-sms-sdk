<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Configuration;

use InvalidArgumentException;
use JsonSerializable;
use Kholenkov\ProstorSmsSdk\Helper\UrlHelper;

final readonly class ApiAccess implements JsonSerializable
{
    public function __construct(
        public string $baseUrl,
        public string $login,
        public string $password,
    ) {
        if (!$baseUrl) {
            throw new InvalidArgumentException('Empty API base URL');
        } elseif (!UrlHelper::isValid($baseUrl)) {
            throw new InvalidArgumentException('Invalid API base URL');
        }

        if (!$login) {
            throw new InvalidArgumentException('Empty API login');
        }

        if (!$password) {
            throw new InvalidArgumentException('Empty API password');
        }
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
