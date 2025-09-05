<?php

namespace App\MiMascota\Shared\Domain\ValueObject;

class DateValueObject
{
    protected \DateTimeImmutable $value;

    public function __construct(string $date)
    {
        if (empty($date)) {
            throw new \InvalidArgumentException('Date cannot be empty.');
        }

        $dateTime = \DateTimeImmutable::createFromFormat('Y-m-d', $date);
        $errors = \DateTimeImmutable::getLastErrors();
        if($errors !== false) {
            if (!$dateTime || $errors['warning_count'] > 0 || $errors['error_count'] > 0) {
                throw new \InvalidArgumentException('Invalid date format. Expected Y-m-d.');
            }
        }

        $this->value = $dateTime;
    }

    public function getValue(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format('Y-m-d');
    }
}
