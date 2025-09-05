<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\Query\GetForumByIdQuery;
use App\MiMascota\Forums\Application\Query\GetForumBySlugQuery;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Shared\Domain\ModelNotFound;

final readonly class ForumGetById
{

    public function __construct(private ForumRepository $repository)
    {
    }

    public function __invoke(GetForumByIdQuery $query): Forum
    {
        $forum = $this->repository->search($query->forumId);
        if ($forum === null) {
         throw new ModelNotFound('forum', 'id', $query->forumId);
        }
        return $forum;
    }

}
