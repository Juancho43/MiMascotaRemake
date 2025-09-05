<?php

namespace App\Tests\MiMascota\Posts\Domain\ValueObject;

use App\MiMascota\Posts\Domain\ValueObject\PostTitle;
use PHPUnit\Framework\TestCase;

class PostTitleTest extends TestCase
{



    public function testCreateFails()
    {
        $postTitle = str_repeat('a', PostTitle::MAX_LENGTH + 1);
        $this->expectException(\App\MiMascota\Shared\Domain\InvalidLength::class);
        PostTitle::create($postTitle);

    }
}
