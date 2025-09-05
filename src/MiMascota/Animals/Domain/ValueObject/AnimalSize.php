<?php

namespace App\MiMascota\Animals\Domain\ValueObject;

use App\MiMascota\Shared\Domain\ValueObject\StringValueObject;



class AnimalSize extends StringValueObject
{
   private const VALID_SIZES = [
        'tiny',
        'small',
        'medium',
        'large',
        'extra_large'
    ];

   private function __construct(string $value)
    {
        parent::__construct($value);

        if (!$this->checkValidSize()) {
            throw new \InvalidArgumentException(sprintf('Invalid animal size: %s', $value));
        }
    }

    public static function generate(string $value) : self
    {
        return new self($value);
    }
   private function checkValidSize() : bool
   {
       return in_array($this->value, self::VALID_SIZES, true);
   }

}
