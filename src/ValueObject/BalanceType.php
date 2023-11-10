<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

enum BalanceType: string
{
    case Rub = 'RUB';
    case Sms = 'SMS';
}
