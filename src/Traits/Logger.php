<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Traits;

use Kholenkov\ProstorSmsSdk\Configuration\Configuration;
use Psr\Http\Message\ResponseInterface;
use Throwable;

trait Logger
{
    protected function logRequest(
        Configuration $configuration,
        string $message,
        string $path,
        array $data = [],
    ): void {
        if ($configuration->logger->isEnabled) {
            if ($configuration->logger->isLogApiAccess) {
                $this->logger?->info(
                    $configuration->logger->generateMessage("{$message}__api_access"),
                    [
                        'baseUrl' => $configuration->apiAccess->baseUrl,
                        'login' => $configuration->apiAccess->login,
                        'password' => $configuration->apiAccess->password,
                    ]
                );
            }

            $this->logger?->info(
                $configuration->logger->generateMessage("{$message}__request"),
                [
                    'data' => $data,
                    'path' => $path,
                ]
            );
        }
    }

    protected function logResponse(
        Configuration $configuration,
        string $message,
        ResponseInterface $response,
    ): void {
        if ($configuration->logger->isEnabled) {
            $this->logger?->info(
                $configuration->logger->generateMessage("{$message}__response"),
                [
                    'body' => (string) $response->getBody(),
                    'reason_phrase' => $response->getReasonPhrase(),
                    'status_code' => $response->getStatusCode(),
                ]
            );
        }
    }

    protected function logThrowable(Configuration $configuration, Throwable $throwable): void
    {
        if ($configuration->logger->isEnabled) {
            $this->logger?->error(
                $throwable->getMessage(),
                [
                    'code' => $throwable->getCode(),
                    'file' => $throwable->getFile(),
                    'line' => $throwable->getLine(),
                    'trace' => $throwable->getTrace(),
                ]
            );
        }
    }
}
