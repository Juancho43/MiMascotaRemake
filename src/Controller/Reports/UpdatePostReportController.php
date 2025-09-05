<?php

namespace App\Controller\Reports;

use App\Commands\CreateForumCommand;
use App\MiMascota\Reports\Application\Command\CreateReportCommand;
use App\MiMascota\Reports\Application\Command\UpdateReportStatusCommand;
use App\MiMascota\Reports\Application\CreateReport;
use App\MiMascota\Reports\Application\DTO\ReportResponse;
use App\MiMascota\Reports\Application\UpdateReportStatus;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdatePostReportController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/reports/put', name: 'update_report', methods: ['PUT'])]
    public function __invoke(Request $request, UpdateReportStatus $report) : Response
    {
        try {
            $this->checkAuthorization($request);
            $data = $request->toArray();
            $command = new UpdateReportStatusCommand(
                $data['postId'],
                $data['status'],
            );

            $response = $report->__invoke($command);
            return $this->successResponse(ReportResponse::generate($response), 'Report updated successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }

    }
}
