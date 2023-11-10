<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Traits;

use Kholenkov\ProstorSmsSdk\Exception\ApiError;
use Psr\Http\Message\ResponseInterface;

trait ResponseProcessor
{
    protected function processResponse(ResponseInterface $response): array
    {
        $responseBody = json_decode((string) $response->getBody(), true);
        if (!is_array($responseBody)) {
            throw new ApiError('Invalid response body');
        }

        return $responseBody;
    }
}
