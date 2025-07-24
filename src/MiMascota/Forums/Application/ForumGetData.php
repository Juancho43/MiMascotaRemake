<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class ForumGetData
{

    public function __construct(private ForumRepository $repository)
    {
    }

    public function __invoke(string $slug): ?Forum
    {
        $forum = $this->repository->getBySlug($slug);
        if (!$forum) {
         throw new ModelNotFound('forum', 'slug', $slug);
        }
        return $forum;
    }

}
