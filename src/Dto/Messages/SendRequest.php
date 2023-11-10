<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Messages;

use DateTimeInterface;
use JsonSerializable;
use Kholenkov\ProstorSmsSdk\ValueObject\MessageStatusQueueName;

final readonly class SendRequest implements JsonSerializable
{
    public function __construct(
        public MessageCollection $messages,
        public ?MessageStatusQueueName $statusQueueName = null,
        public ?DateTimeInterface $scheduleTime = null,
        public ?bool $showBillingDetails = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public function toArray(): array
    {
        $array = ['messages' => $this->messages->toArray()];

        if (null !== $this->statusQueueName) {
            $array['statusQueueName'] = (string) $this->statusQueueName;
        }

        if (null !== $this->scheduleTime) {
            $array['scheduleTime'] = $this->scheduleTime->format(DateTimeInterface::RFC3339);
        }

        if (null !== $this->showBillingDetails) {
            $array['showBillingDetails'] = $this->showBillingDetails;
        }

        return $array;
    }
}
