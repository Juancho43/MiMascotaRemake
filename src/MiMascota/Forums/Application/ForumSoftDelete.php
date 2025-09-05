<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserRole;

final readonly class ForumSoftDelete
{
    public function __construct(private ForumRepository $forumRepository)
    {

    }

    public function __invoke(string $forumId, User $user) : Forum
    {
        if($user->getRole()->getRole() !== UserRole::ADMIN) {
            throw new \InvalidArgumentException('You do not have permission to delete this forum.');
        }
        $forum = $this->forumRepository->search($forumId);
        if (!$forum) {
            throw new \InvalidArgumentException('Forum not found.');
        }
        $forum->getSoftDelete()->markAsDeleted();
        $forum->getTimeStamp()->update();
        $this->forumRepository->save($forum);
        return $forum;
    }
}
