<?php

namespace App\Controller\Reports;

use App\Commands\CreateForumCommand;
use App\MiMascota\Reports\Application\Command\CreateReportCommand;
use App\MiMascota\Reports\Application\CreateReport;
use App\MiMascota\Reports\Application\DTO\ReportResponse;
use App\MiMascota\Reports\Application\DTO\ReportResponseCollection;
use App\MiMascota\Reports\Application\GetReportsByForumAndLocation;
use App\MiMascota\Reports\Application\Query\GetReportsByForumAndLocationQuery;
use App\MiMascota\Reports\Domain\ValueObject\ReportReason;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAllReportsByForumController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/reports/by/{locationSlug}/{forumSlug}/{page}/{limit}', name: 'get_forums_reports', methods: ['GET'])]
    public function __invoke(Request $request, string $locationSlug, string $forumSlug,string $page,string $limit, GetReportsByForumAndLocation $reports) : Response
    {
        try {
            $this->checkAuthorization($request);
            $query = new GetReportsByForumAndLocationQuery(
                forumSlug: $forumSlug,
                locationSlug: $locationSlug,
                page: (int)$page,
                limit: (int)$limit
            );
            $data = $reports->__invoke($query);
            return $this->successResponse( ReportResponseCollection::generate($data), 'Reports retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }

    }
}
