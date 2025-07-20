<?php
namespace App\MiMascota\Users\Domain\ValueObject;
use App\MiMascota\Users\Domain\User;

class UserPreference
{
    private const MAX_LENGTH = 255;
    private const MIN_LENGTH = 6;

   public function __construct(
        private string $id,
        private User $user,
        private string $preference,
        private mixed $value
    ) {
        if (empty($id)) {
            throw new \InvalidArgumentException('ID cannot be empty.');
        }
        if (empty($preference)) {
            throw new \InvalidArgumentException('Preference cannot be empty.');
        }
        if (!$user instanceof User) {
            throw new \InvalidArgumentException('User must be a valid User object.');
        }
        if (strlen($preference) < self::MIN_LENGTH || strlen($preference) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException("Preference must be between " . self::MIN_LENGTH . " and " . self::MAX_LENGTH . " characters.");
        }
    }

    public static function create(string $id,User $user,string $preference, mixed $value): self
    {
        return new self($id,$user,$preference,$value);
    }


}
