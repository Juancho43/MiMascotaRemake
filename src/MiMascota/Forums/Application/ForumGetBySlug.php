<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\Query\GetForumBySlugQuery;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class ForumGetBySlug
{

    public function __construct(private ForumRepository $repository)
    {
    }

    public function __invoke(GetForumBySlugQuery $query): Forum
    {
        $forum = $this->repository->getBySlug($query->forumSlug);
        if ($forum === null) {
         throw new ModelNotFound('forum', 'slug', $query->forumSlug);
        }
        return $forum;
    }

}
