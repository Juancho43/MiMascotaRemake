<?php

namespace App\MiMascota\Users\Domain\ValueObject;

class UserPassword
{
    private string $value;
    public function __construct(string $password)
    {
        $this->value = password_hash($password, PASSWORD_DEFAULT);
    }

    public static function create(string $password): self
    {
        return new self($password);
    }
    public function verify($password): bool
    {
        return password_verify($password,$this->value);
    }

    public function getValue()
    {
        return $this->value;
    }
}
