<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Interfaces;

use Kholenkov\ProstorSmsSdk\Configuration\ApiAccess;
use Psr\Http\Message\ResponseInterface;

interface HttpClient
{
    public function post(ApiAccess $apiAccess, string $path, array $data = []): ResponseInterface;
}
