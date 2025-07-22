<?php

namespace App\Tests\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\ForumCreator;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Users\Application\UserChangePassword;
use App\MiMascota\Users\Domain\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumCreatorTest extends KernelTestCase
{

    private ForumCreator $forumCreator;
    private ForumRepository $forumRepository;
    public function setUp(): void
    {
        self::bootKernel();
        parent::setUp();
        $this->forumRepository = $this->createMock(ForumRepository::class);
        $this->forumCreator = new ForumCreator($this->forumRepository);
    }

    public function test__invoke(): void
    {

        $forumName = "Test Forum";
        $forumDescription = "This is a test forum description.";

        $this->forumRepository->expects($this->once())->method('save');

        $forum = $this->forumCreator->__invoke($forumName, $forumDescription);

        $this->assertInstanceOf(Forum::class, $forum);

    }


}



