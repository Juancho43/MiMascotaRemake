<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Journals\Domain\ValueObject\JournalSlug;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;

class JournalMock
{
    public static function generate($id, User $user, Animal $animal) : Journal
    {
        return Journal::create(
            $id,
            JournalSlug::create(SlugGenerator::generate($animal->getName())),
            $user,
            $animal,
        );
    }
}
