<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\ValueObject;

enum ResponseStatus: string
{
    case Error = 'error';
    case Ok = 'ok';
}
