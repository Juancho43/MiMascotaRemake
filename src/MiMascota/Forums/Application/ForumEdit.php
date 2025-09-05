<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Application\Command\EditForumCommand;
use App\MiMascota\Forums\Application\Query\GetForumByIdQuery;
use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Forums\Domain\ValueObject\ForumDescription;
use App\MiMascota\Forums\Domain\ValueObject\ForumName;
use App\MiMascota\Forums\Domain\ValueObject\ForumSlug;
use App\MiMascota\Shared\SlugGenerator;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserRole;

final readonly class ForumEdit
{
    public function __construct(
        private ForumRepository $forumRepository,
        private ForumGetById $forumGetById,
        private UserGetById $userGetById

    )
    {
    }

    public function __invoke(EditForumCommand $command): Forum
    {
        $user = $this->userGetById->__invoke(new GetUserByIdQuery($command->userId));
        if ($user->getRole()->getRole() !== UserRole::ADMIN && $user->getRole()->getRole() !== UserRole::MODERATOR) {
            throw new \InvalidArgumentException('You do not have permission to edit forums.');
        }

        $forum = $this->forumGetById->__invoke(new GetForumByIdQuery($command->forumId));
        $forum->setName(ForumName::create($command->name));
        $forum->setSlug(ForumSlug::create(SlugGenerator::generate($command->name)));
        $forum->setDescription(ForumDescription::create($command->description));
        $forum->getTimeStamp()->update();
        $this->forumRepository->save($forum);

        return $forum;
    }
}
