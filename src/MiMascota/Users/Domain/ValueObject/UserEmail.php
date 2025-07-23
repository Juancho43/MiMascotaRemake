<?php

namespace App\MiMascota\Users\Domain\ValueObject;

use App\MiMascota\Shared\Domain\CannotBeEmpty;
use App\MiMascota\Shared\Domain\InvalidFormat;
use App\MiMascota\Users\Domain\Exceptions\UserEmailInvalidCode;

class UserEmail
{
    private string $value;
    public string $code;
    private bool $isVerified = false;

    public function __construct(string $email)
    {
      try {
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              throw new InvalidFormat($email,'email');
          }
          $this->code = bin2hex(random_bytes(3));
          $this->value = $email;
      } catch (\Exception $e) {
          throw $e;
      }
    }

    public static function create(string $email): self
    {
        if (empty($email)) {
            throw new CannotBeEmpty('email');
        }
        return new self($email);
    }

    public function getCode() : string
    {
        return $this->code;
    }

    public function verifyCode(string $code): bool
    {

            if ($this->isVerified) {
                return true;
            }
            if ($this->code !== $code) {
                throw new UserEmailInvalidCode($this->value);
            }
            $this->isVerified = true;
            return true;

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
