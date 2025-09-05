<?php

namespace App\MiMascota\Reports\Application;

use App\MiMascota\Posts\Application\PostGetById;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Reports\Application\Command\CreateReportCommand;
use App\MiMascota\Reports\Application\Command\UpdateReportStatusCommand;
use App\MiMascota\Reports\Application\Query\GetReportByIdQuery;
use App\MiMascota\Reports\Domain\ReportRepository;
use App\MiMascota\Reports\Domain\Report;
use App\MiMascota\Reports\Domain\ValueObject\ReportReason;
use App\MiMascota\Reports\Domain\ValueObject\ReportStatus;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use Ramsey\Uuid\Uuid;

class UpdateReportStatus
{

    public function __construct(
        private ReportRepository $repository,
        private ReportGetById $reportGetById,
    )
    {
    }

    public function __invoke(UpdateReportStatusCommand $command): Report
    {
        $report = $this->reportGetById->__invoke(new GetReportByIdQuery($command->id));
        $report->setStatus(ReportStatus::create($command->status));
        $this->repository->save($report);
        return $report;
    }
}
