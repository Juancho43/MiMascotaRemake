<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Shared\SlugGenerator;

final readonly class ForumEdit
{
    public function __construct(private ForumRepository $forumRepository)
    {
    }

    public function __invoke(string $id,string $name, string $description): Forum
    {
        $forum = $this->forumRepository->search($id);
        if (!$forum) {
            throw new \InvalidArgumentException('Forum not found.');
        }
        $forum->setName($name);
        $forum->setSlug(SlugGenerator::generate($name));
        $forum->setDescription($description);

        $this->forumRepository->save($forum);

        return $forum;
    }
}
