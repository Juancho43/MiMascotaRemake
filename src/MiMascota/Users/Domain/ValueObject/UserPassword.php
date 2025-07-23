<?php

namespace App\MiMascota\Users\Domain\ValueObject;


use App\MiMascota\Shared\Domain\CannotBeEmpty;
use App\MiMascota\Shared\Domain\InvalidFormat;
use App\MiMascota\Users\Domain\Exceptions\UserPasswordIncorrect;

class UserPassword
{
    private string $value;
    public function __construct(string $password)
    {
        $this->value = $this->generate($password);
    }

    public static function create(string $password): self
    {
        return new self($password);
    }
    public function verify($password): bool
    {
        if (!is_string($password) || trim($password) === '') {
            throw new InvalidFormat($password, 'string');
        }

        if (!password_verify($password, $this->value)) {
            throw new UserPasswordIncorrect();
        }
        return true;
    }

    public function getValue() : string
    {
        return $this->value;
    }
    public function change($password): void
    {
        $this->value = $this->generate($password);
    }
    private function generate(string $password): string
    {
        if(trim($password) === '') {
            throw new CannotBeEmpty('password');
        }

        return password_hash($password, PASSWORD_BCRYPT);
    }

}
