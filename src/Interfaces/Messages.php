<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Interfaces;

use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusQueueRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\GetStatusResponse;
use Kholenkov\ProstorSmsSdk\Dto\Messages\SendRequest;
use Kholenkov\ProstorSmsSdk\Dto\Messages\SendResponse;

interface Messages
{
    public function getStatus(GetStatusRequest $request): GetStatusResponse;

    public function getStatusQueue(GetStatusQueueRequest $request): GetStatusResponse;

    public function send(SendRequest $request): SendResponse;
}
