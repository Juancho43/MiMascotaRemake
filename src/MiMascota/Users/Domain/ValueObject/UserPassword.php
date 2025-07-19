<?php

namespace App\MiMascota\Users\Domain\ValueObject;


class UserPassword
{
    private string $value;
    public function __construct(string $password)
    {
        try {
            $this->value = $this->generate($password);
        } catch (\Exception $exception) {
            throw new \Exception('Error creating password: ' . $exception->getMessage());
        }
    }

    public static function create(string $password): self
    {
        return new self($password);
    }
    public function verify($password): bool
    {
        if (!is_string($password) || trim($password) === '') {
            throw new \TypeError('Password must be a string');
        }

        if (!password_verify($password, $this->value)) {
            throw new \Exception('Password is not valid');
        }
        return true;
    }

    public function getValue() : string
    {
        return $this->value;
    }
    public function change($password): void
    {
        try {
            $this->value = $this->generate($password);
        }catch (\Exception $exception){
            throw new \Exception('Error changing password: ' . $exception->getMessage());
        }
    }
    private function generate(string $password, $algorithm = PASSWORD_BCRYPT): string
    {
        try {
            if(trim($password) === '') {
                throw new \Exception('Password cannot be empty');
            }

            return password_hash($password, $algorithm);
        } catch (\Exception $exception) {
            throw new \Exception('Error generating password hash: ' . $exception->getMessage());
        }
    }

}
