<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Interfaces;

use Kholenkov\ProstorSmsSdk\Dto\Utility\GetBalanceResponse;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetSendersResponse;
use Kholenkov\ProstorSmsSdk\Dto\Utility\GetVersionResponse;

interface Utility
{
    public function getBalance(): GetBalanceResponse;

    public function getSenders(): GetSendersResponse;

    public function getVersion(): GetVersionResponse;
}
