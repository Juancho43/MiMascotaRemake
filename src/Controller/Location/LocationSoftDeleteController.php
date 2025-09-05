<?php

namespace App\Controller\Location;

use App\MiMascota\Forums\Application\ForumSoftDelete;
use App\MiMascota\Locations\Application\Query\GetLocationByIdQuery;
use App\MiMascota\Locations\Application\SoftDeleteLocation;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationSoftDeleteController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;
    #[Route('locations/delete/{id}', name: 'location_soft_delete', methods: ['DELETE'])]
    public function __invoke(Request  $request,string $id ,SoftDeleteLocation $forumSoftDelete) : Response
    {
        try {
            $this->checkAuthorization($request);
            $command = new GetLocationByIdQuery($id);
            $forumSoftDelete->__invoke($command);
            return $this->successResponse(message: 'Location deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
