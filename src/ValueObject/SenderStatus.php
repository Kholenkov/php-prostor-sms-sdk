<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

enum SenderStatus: string
{
    case Active = 'active';
    case Blocked = 'blocked';
    case Default = 'default';
    case New = 'new';
    case Pending = 'pending';
}
