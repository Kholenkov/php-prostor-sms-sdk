<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Utility;

use InvalidArgumentException;
use JsonSerializable;
use Kholenkov\ProstorSmsSdk\Helper\ArrayHelper;
use Kholenkov\ProstorSmsSdk\ValueObject\ResponseStatus;

final readonly class GetVersionResponse implements JsonSerializable
{
    public function __construct(
        public int $httpStatusCode,
        public ResponseStatus $status,
        public ?string $version = null,
        public ?string $description = null,
    ) {
    }

    public static function fromArray(int $httpStatusCode, array $array): self
    {
        $statusValue = ArrayHelper::getString($array, 'status');
        $status = ResponseStatus::tryFrom($statusValue);
        if (null === $status) {
            throw new InvalidArgumentException('Invalid argument "status"');
        }

        if (ResponseStatus::Error === $status) {
            return new self(
                $httpStatusCode,
                $status,
                null,
                ArrayHelper::getStringNullable($array, 'description'),
            );
        }

        return new self(
            $httpStatusCode,
            $status,
            ArrayHelper::getString($array, 'version'),
        );
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
