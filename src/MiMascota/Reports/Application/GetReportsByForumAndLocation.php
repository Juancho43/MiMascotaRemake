<?php

namespace App\MiMascota\Reports\Application;

use App\MiMascota\Reports\Application\Query\GetReportsByForumAndLocationQuery;
use App\MiMascota\Reports\Domain\ReportRepository;

final readonly class GetReportsByForumAndLocation
{
    public function __construct(private ReportRepository $repository)
    {
    }

    public function __invoke(GetReportsByForumAndLocationQuery $query) : array
    {
        return $this->repository->findByForumAndLocation($query->forumSlug, $query->locationSlug, $query->page, $query->limit);
    }
}
