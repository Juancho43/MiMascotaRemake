<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;

class ForumGetData
{

    public function __construct(private ForumRepository $repository)
    {
    }

    public function __invoke(string $slug): ?Forum
    {
        $forum = $this->repository->getBySlug($slug);
        if (!$forum) {
         throw new \Exception('Forum not found');
        }
        return $forum;
    }

}
