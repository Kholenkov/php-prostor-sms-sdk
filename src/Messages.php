<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk;

use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusQueueRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusResponse;
use Kholenkov\ProstorSmsSdk\Dto\Messages\SendRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\SendResponse;
use Psr\Log\LoggerInterface;
use Throwable;

class Messages implements Interfaces\Messages
{
    use Traits\Logger;
    use Traits\ResponseProcessor;

    public function __construct(
        private readonly Configuration\Configuration $configuration,
        private readonly Interfaces\HttpClient $httpClient,
        private readonly ?LoggerInterface $logger = null,
    ) {
    }

    public function getStatus(GetStatusRequest $request): GetStatusResponse
    {
        try {
            $requestPath = '/status.json';
            $requestData = $request->toArray();

            $this->logRequest($this->configuration, 'get_status', $requestPath, $requestData);


            $response = $this->httpClient->post($this->configuration->apiAccess, $requestPath, $requestData);

            $this->logResponse($this->configuration, 'get_status', $response);


            return GetStatusResponse::fromArray(
                $response->getStatusCode(),
                $this->processResponse($response),
            );
        } catch (Throwable $throwable) {
            $this->logThrowable($this->configuration, $throwable);

            throw $throwable;
        }
    }

    public function getStatusQueue(GetStatusQueueRequest $request): GetStatusResponse
    {
        try {
            $requestPath = '/statusQueue.json';
            $requestData = $request->toArray();

            $this->logRequest($this->configuration, 'get_status_queue', $requestPath, $requestData);


            $response = $this->httpClient->post($this->configuration->apiAccess, $requestPath, $requestData);

            $this->logResponse($this->configuration, 'get_status_queue', $response);


            return GetStatusResponse::fromArray(
                $response->getStatusCode(),
                $this->processResponse($response),
            );
        } catch (Throwable $throwable) {
            $this->logThrowable($this->configuration, $throwable);

            throw $throwable;
        }
    }

    public function send(SendRequest $request): SendResponse
    {
        try {
            $requestPath = '/send.json';
            $requestData = $request->toArray();

            $this->logRequest($this->configuration, 'send', $requestPath, $requestData);


            $response = $this->httpClient->post($this->configuration->apiAccess, $requestPath, $requestData);

            $this->logResponse($this->configuration, 'send', $response);


            return SendResponse::fromArray(
                $response->getStatusCode(),
                $this->processResponse($response),
            );
        } catch (Throwable $throwable) {
            $this->logThrowable($this->configuration, $throwable);

            throw $throwable;
        }
    }
}
