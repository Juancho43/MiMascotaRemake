<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\Command\CreateForumCommand;
use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ValueObject\ForumDescription;
use App\MiMascota\Forums\Domain\ValueObject\ForumName;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Forums\Domain\ValueObject\ForumSlug;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserRole;
use Ramsey\Uuid\Uuid;

final readonly class ForumCreator
{

    public function __construct(private  ForumRepository $forumRepository)
    {
    }

    public function __invoke(CreateForumCommand $command): Forum
    {

        $forum = Forum::create(
            id: Uuid::uuid4()->toString(),
            name: ForumName::create($command->name),
            slug: ForumSlug::create(SlugGenerator::generate($command->name)),
            description: ForumDescription::create($command->description)
        );
        $this->forumRepository->save($forum);
        return $forum;
    }
}
