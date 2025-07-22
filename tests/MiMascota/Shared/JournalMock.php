<?php

namespace App\Tests\MiMascota\Shared;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;

class JournalMock
{
    public static function generate($id,$slug, User $user, Animal $animal) : Journal
    {
        return Journal::create(
            $id,
            SlugGenerator::generate($slug),
            $user,
            $animal,
        );
    }
}
