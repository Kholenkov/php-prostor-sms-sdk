<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Messages;

use JsonSerializable;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageId;
use Kholenkov\ProstorSmsSdk\ValueObject\PhoneNumber;
use Kholenkov\ProstorSmsSdk\ValueObject\SenderName;

final readonly class Message implements JsonSerializable
{
    public function __construct(
        public MessageId $clientId,
        public PhoneNumber $phone,
        public string $text,
        public ?SenderName $sender = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public function toArray(): array
    {
        $array = [
            'clientId' => (string) $this->clientId,
            'phone' => (string) $this->phone,
            'text' => $this->text,
        ];

        if (null !== $this->sender) {
            $array['sender'] = (string) $this->sender;
        }

        return $array;
    }
}
