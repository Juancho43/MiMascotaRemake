<?php

namespace App\MiMascota\Users\Domain\ValueObject;

class UserEmail
{
    private string $email;
    public string $code;
    private bool $isVerified = false;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format");
        }
//        $this->code = implode('', array_map(fn() => random_int(0, 9), range(1, 6)));
        $this->code= bin2hex(random_bytes(3)); // Generates a 6-character hex code
        $this->email = $email;
    }

    public static function create(string $email): self
    {
        return new self($email);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function verifyCode(string $code): bool
    {
        if ($this->isVerified) {
            return true;
        }
        if ($this->code !== $code) {
            throw new \InvalidArgumentException("Invalid verification code");
        }
        $this->isVerified = true;
        return true;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }
}
