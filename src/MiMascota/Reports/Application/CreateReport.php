<?php

namespace App\MiMascota\Reports\Application;

use App\MiMascota\Posts\Application\PostGetById;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Reports\Application\Command\CreateReportCommand;
use App\MiMascota\Reports\Domain\ReportRepository;
use App\MiMascota\Reports\Domain\Report;
use App\MiMascota\Reports\Domain\ValueObject\ReportReason;
use App\MiMascota\Reports\Domain\ValueObject\ReportStatus;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use Ramsey\Uuid\Uuid;

class CreateReport
{

    public function __construct(
        private ReportRepository $repository,
        private UserGetById $getUserById,
        private PostGetById $getPostById
    )
    {
    }

    public function __invoke(CreateReportCommand $command): Report
    {
        $user = $this->getUserById->__invoke(new GetUserByIdQuery($command->reporterUserId));
        $post = $this->getPostById->__invoke(new GetPostByIdQuery($command->reportedPostId));

        $report = Report::create(
            Uuid::uuid4()->toString(),
            $post,
            $user,
            ReportReason::create($command->reason),
            ReportStatus::create($command->status),
        );


        $this->repository->save($report);
        return $report;
    }
}
