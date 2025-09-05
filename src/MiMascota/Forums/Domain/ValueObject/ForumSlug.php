<?php

namespace App\MiMascota\Forums\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\SlugValueObject;
use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;

class ForumSlug extends SlugValueObject
{
    public static function create(string $value): self
    {
        return new self($value);
    }
    public function getValue(): string
    {
        return $this->value;
    }
}
