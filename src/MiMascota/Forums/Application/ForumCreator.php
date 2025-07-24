<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Shared\SlugGenerator;
use Ramsey\Uuid\Uuid;

final readonly class ForumCreator
{

    public function __construct(private readonly ForumRepository $forumRepository)
    {
    }

    public function __invoke(string $name, string $description): Forum
    {
        $forum = Forum::create(
            id: Uuid::uuid4()->toString(),
            name: $name,
            slug: SlugGenerator::generate($name),
            description: $description
        );

        $this->forumRepository->save($forum);

        return $forum;
    }
}
