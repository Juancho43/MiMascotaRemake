<?php

namespace App\MiMascota\Users\Domain\ValueObject;

class UserEmail
{
    private string $value;
    public string $code;
    private bool $isVerified = false;

    public function __construct(string $email)
    {
      try {
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              throw new \Exception("Invalid email format");
          }
          $this->code = bin2hex(random_bytes(3));
          $this->value = $email;
      } catch (\Exception $e) {
          throw $e;
      }
    }

    public static function createNew(string $email): self
    {
        if (empty($email)) {
            throw new \Exception("Email cannot be empty");
        }
        return new self($email);
    }

    public function getCode() : string
    {
        return $this->code;
    }

    public function verifyCode(string $code): bool
    {
        try {
            if ($this->isVerified) {
                return true;
            }
            if ($this->code !== $code) {
                throw new \Exception("Invalid verification code");
            }
            $this->isVerified = true;
            return true;

        } catch (\Exception $e) {
            throw new \Exception("Verification failed: " . $e->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }
}
