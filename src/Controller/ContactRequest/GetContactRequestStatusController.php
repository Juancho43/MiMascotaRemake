<?php

namespace App\Controller\ContactRequest;

use App\Commands\CreateForumCommand;
use App\MiMascota\ContactRequests\Domain\ContactRequest;
use App\MiMascota\ContactRequests\Domain\ContactRequestStatus;
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

class GetContactRequestStatusController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/contactRequest/status', name: 'get_contact_requests_status', methods: ['GET'])]
    public function __invoke() : Response
    {
        try {
            return $this->successResponse( ContactRequestStatus::getValidStatuses(), 'ContactRequest statuses retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }

    }
}
