<?php

declare(strict_types=1);

namespace KholenkovTest\ProstorSmsSdk\Traits;

use Kholenkov\ProstorSmsSdk\Configuration\Configuration;
use Kholenkov\ProstorSmsSdk\Traits;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class ClassWithTraits
{
    use Traits\Logger;
    use Traits\ResponseProcessor;

    public function __construct(protected readonly ?LoggerInterface $logger = null)
    {
    }

    public function publicLogRequest(
        Configuration $configuration,
        string $message,
        string $path,
        array $data = [],
    ): void {
        $this->logRequest($configuration, $message, $path, $data);
    }

    public function publicLogResponse(
        Configuration $configuration,
        string $message,
        ResponseInterface $response,
    ): void {
        $this->logResponse($configuration, $message, $response);
    }

    public function publicLogThrowable(Configuration $configuration, Throwable $throwable): void
    {
        $this->logThrowable($configuration, $throwable);
    }

    public function publicProcessResponse(ResponseInterface $response): array
    {
        return $this->processResponse($response);
    }
}
