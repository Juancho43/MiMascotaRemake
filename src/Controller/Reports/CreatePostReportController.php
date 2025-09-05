<?php

namespace App\Controller\Reports;

use App\Commands\CreateForumCommand;
use App\MiMascota\Reports\Application\Command\CreateReportCommand;
use App\MiMascota\Reports\Application\CreateReport;
use App\MiMascota\Reports\Application\DTO\ReportResponse;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreatePostReportController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/reports/post', name: 'create_post_report', methods: ['POST'])]
    public function __invoke(Request $request, CreateReport $report) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            $command = new CreateReportCommand(
                $user->getId(),
                $data['postId'],
                $data['reason'],
                'Pending'
            );

            $response = $report->__invoke($command);
            return $this->successResponse(ReportResponse::generate($response), 'Report created successfully', Response::HTTP_CREATED);
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }

    }
}
