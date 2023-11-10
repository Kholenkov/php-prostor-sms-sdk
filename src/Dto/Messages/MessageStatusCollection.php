<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Messages;

use Countable;
use InvalidArgumentException;
use Iterator;
use JsonSerializable;

/**
 * Class MessageStatusCollection
 *
 * @implements Iterator<int, MessageStatus>
 */
final class MessageStatusCollection implements Countable, Iterator, JsonSerializable
{
    private int $key;
    private array $values;

    public function __construct(MessageStatus ...$values)
    {
        $this->key = 0;
        $this->values = $values;
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function current(): MessageStatus
    {
        return $this->values[$this->key];
    }

    public static function fromArray(array $array, string $keyForException = ''): self
    {
        if ($keyForException) {
            $keyForException .= '.';
        }

        $values = [];
        foreach ($array as $i => $value) {
            if (!is_array($value)) {
                throw new InvalidArgumentException(
                    sprintf('Argument "%s" is not array', "{$keyForException}[{$i}]")
                );
            }

            $values[] = MessageStatus::fromArray($value, "{$keyForException}[{$i}]");
        }

        return new self(...$values);
    }

    public function jsonSerialize(): array
    {
        $array = [];
        foreach ($this->values as $value) {
            $array[] = $value->jsonSerialize();
        }
        return $array;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function next(): void
    {
        ++$this->key;
    }

    public function rewind(): void
    {
        $this->key = 0;
    }

    public function valid(): bool
    {
        return isset($this->values[$this->key]);
    }
}
