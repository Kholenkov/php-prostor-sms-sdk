<?php

declare(strict_types=1);

namespace Kholenkov\ProstorSmsSdk\Dto\Messages;

use Countable;
use Iterator;
use JsonSerializable;

/**
 * Class MessageCollection
 *
 * @implements Iterator<int, Message>
 */
final class MessageCollection implements Countable, Iterator, JsonSerializable
{
    private int $key;
    private array $values;

    public function __construct(Message ...$values)
    {
        $this->key = 0;
        $this->values = $values;
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function current(): Message
    {
        return $this->values[$this->key];
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

    public function toArray(): array
    {
        $array = [];
        foreach ($this->values as $value) {
            $array[] = $value->toArray();
        }
        return $array;
    }

    public function valid(): bool
    {
        return isset($this->values[$this->key]);
    }
}
