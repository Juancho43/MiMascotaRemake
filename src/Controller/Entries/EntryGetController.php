<?php

namespace App\Controller\Entries;

use App\MiMascota\Entries\Application\EntryGetOne;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Infrastructure\CheckToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EntryGetController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;

    #[Route('/entry/{id}', name: 'entry_get', methods: ['GET'])]
    public function __invoke(
        Request             $request,
        string              $id,
        EntryGetOne         $getOne,
    ): JsonResponse
    {
        $this->checkAuthorization($request );

        return $this->successResponse(
            $getOne->__invoke($id),
            'Entry retrieved successfully'
        );

    }

}
