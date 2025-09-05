<?php

namespace App\Controller\ContactRequest;

use App\MiMascota\ContactRequests\Application\DTO\ContactRequestResponseCollection;
use App\MiMascota\ContactRequests\Application\GetAllContactRequestByRequester;
use App\MiMascota\ContactRequests\Application\Query\GetAllContactRequestByUserQuery;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAllContactRequestByRequesterController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('/contactRequest/get/requester/{id}', name: 'get_contact_requests_requester', methods: ['GET'])]
    public function __invoke(Request $request, string $id, GetAllContactRequestByRequester $byRequester) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            if ($user->getId() !== $id) {
                return $this->errorResponse('Unauthorized access', Response::HTTP_UNAUTHORIZED);
            }
            $response = $byRequester->__invoke(new GetAllContactRequestByUserQuery($id));
            return $this->successResponse( ContactRequestResponseCollection::generate($response), 'Contact Requests retrieved successfully');
        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage());
        }

    }
}
