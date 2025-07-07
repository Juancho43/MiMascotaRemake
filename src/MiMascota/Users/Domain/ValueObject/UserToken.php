<?php

namespace App\MiMascota\Users\Domain\ValueObject;

class UserToken
{
    private ?string $value;

    private function __construct(
    ) {
        $this->value = bin2hex(random_bytes(16));
    }

    public static function generate(): self
    {
        return new self();
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function reset() : void
    {
        $this->value = null;
    }
}
