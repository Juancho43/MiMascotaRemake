<?php

namespace App\Controller\ContactRequest;

use App\Commands\CreateForumCommand;
use App\MiMascota\ContactRequests\Application\DTO\ContactRequestResponse;
use App\MiMascota\ContactRequests\Application\CreateContactRequest;
use App\MiMascota\ContactRequests\Application\Command\CreateContactRequestCommand;
use App\MiMascota\Reports\Application\Command\CreateReportCommand;
use App\MiMascota\Reports\Application\CreateReport;
use App\MiMascota\Reports\Application\DTO\ReportResponse;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateContactRequestController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/contactRequest/create', name: 'create_contact_request', methods: ['POST'])]
    public function __invoke(Request $request, CreateContactRequest $createContactRequest) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            $command = new CreateContactRequestCommand(
                Uuid::uuid4()->toString(),
                $data['requesterId'],
                $data['ownerId'],
                $data['postId'],
                $data['status']
            );

            $response = $createContactRequest->__invoke($command);
            return $this->successResponse(ContactRequestResponse::generate($response), 'ContactRequest created successfully', Response::HTTP_CREATED);
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }

    }
}
