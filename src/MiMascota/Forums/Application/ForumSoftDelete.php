<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Domain\ForumRepository;

final readonly class ForumSoftDelete
{
    public function __construct(private ForumRepository $forumRepository)
    {

    }
    public function __invoke(string $forumId)
    {
        $forum = $this->forumRepository->search($forumId);
        if (!$forum) {
            throw new \InvalidArgumentException('Forum not found.');
        }
        $forum->getSoftDelete()->markAsDeleted();
        $this->forumRepository->save($forum);
        return $forum;
    }
}
