<?php

namespace App\MiMascota\Reports\Application;

use App\MiMascota\Posts\Application\PostGetById;
use App\MiMascota\Posts\Application\Query\GetPostByIdQuery;
use App\MiMascota\Reports\Application\Command\CreateReportCommand;
use App\MiMascota\Reports\Application\Query\GetReportByIdQuery;
use App\MiMascota\Reports\Domain\ReportRepository;
use App\MiMascota\Reports\Domain\Report;
use App\MiMascota\Reports\Domain\ValueObject\ReportReason;
use App\MiMascota\Reports\Domain\ValueObject\ReportStatus;
use App\MiMascota\Shared\Domain\ModelNotFound;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Application\Query\GetUserByIdQuery;
use App\MiMascota\Users\Application\UserGetById;
use Ramsey\Uuid\Uuid;

class ReportGetById
{

    public function __construct(
        private ReportRepository $repository,

    )
    {
    }

    public function __invoke(GetReportByIdQuery $query): Report
    {

        $report = $this->repository->findById($query->reportId);
        if(!$report){
            throw new ModelNotFound("Report");
        }
        return $report;
    }
}
