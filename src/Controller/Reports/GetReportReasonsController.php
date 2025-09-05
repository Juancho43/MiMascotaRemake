<?php

namespace App\Controller\Reports;

use App\Commands\CreateForumCommand;
use App\MiMascota\Reports\Application\Command\CreateReportCommand;
use App\MiMascota\Reports\Application\CreateReport;
use App\MiMascota\Reports\Application\DTO\ReportResponse;
use App\MiMascota\Reports\Domain\ValueObject\ReportReason;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetReportReasonsController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/reports/reasons', name: 'get_reports_reasons', methods: ['GET'])]
    public function __invoke(Request $request, CreateReport $report) : Response
    {
        try {
            return $this->successResponse( ReportReason::getValidReasons(), 'Report reasons');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }

    }
}
