<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk;

use Kholenkov\ProstorSmsSdk\Dto\Utility\GetBalanceResponse;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetSendersResponse;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetVersionResponse;
use Psr\Log\LoggerInterface;
use Throwable;

class Utility implements Interfaces\Utility
{
    use Traits\Logger;
    use Traits\ResponseProcessor;

    public function __construct(
        private readonly Configuration\Configuration $configuration,
        private readonly Interfaces\HttpClient $httpClient,
        private readonly ?LoggerInterface $logger = null,
    ) {
    }

    public function getBalance(): GetBalanceResponse
    {
        try {
            $requestPath = '/balance.json';

            $this->logRequest($this->configuration, 'get_balance', $requestPath);


            $response = $this->httpClient->post($this->configuration->apiAccess, $requestPath);

            $this->logResponse($this->configuration, 'get_balance', $response);


            return GetBalanceResponse::fromArray(
                $response->getStatusCode(),
                $this->processResponse($response),
            );
        } catch (Throwable $throwable) {
            $this->logThrowable($this->configuration, $throwable);

            throw $throwable;
        }
    }

    public function getSenders(): GetSendersResponse
    {
        try {
            $requestPath = '/senders.json';

            $this->logRequest($this->configuration, 'get_senders', $requestPath);


            $response = $this->httpClient->post($this->configuration->apiAccess, $requestPath);

            $this->logResponse($this->configuration, 'get_senders', $response);


            return GetSendersResponse::fromArray(
                $response->getStatusCode(),
                $this->processResponse($response),
            );
        } catch (Throwable $throwable) {
            $this->logThrowable($this->configuration, $throwable);

            throw $throwable;
        }
    }

    public function getVersion(): GetVersionResponse
    {
        try {
            $requestPath = '/version.json';

            $this->logRequest($this->configuration, 'get_version', $requestPath);


            $response = $this->httpClient->post($this->configuration->apiAccess, $requestPath);

            $this->logResponse($this->configuration, 'get_version', $response);


            return GetVersionResponse::fromArray(
                $response->getStatusCode(),
                $this->processResponse($response),
            );
        } catch (Throwable $throwable) {
            $this->logThrowable($this->configuration, $throwable);

            throw $throwable;
        }
    }
}
