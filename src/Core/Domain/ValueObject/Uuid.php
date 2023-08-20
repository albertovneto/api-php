<?php

namespace Core\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;
use InvalidArgumentException;

class Uuid
{
    public function __construct(
        protected string $value
    ) {
        $this->ensureIsValid();
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function ensureIsValid()
    {
        if (RamseyUuid::isValid($this->value) === false) {
            throw new InvalidArgumentException();
        }

        return true;
    }

    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }
}