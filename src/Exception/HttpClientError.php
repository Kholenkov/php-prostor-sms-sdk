<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Exception;

use Exception;
use Throwable;

class HttpClientError extends Exception
{
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null)
    {
        if ('' === $message) {
            $message = 'HTTP client error';
        }
        parent::__construct($message, $code, $previous);
    }
}
