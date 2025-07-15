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
        CheckToken          $login,
        string              $id,
        EntryGetOne         $getOne,
        NormalizerInterface $normalizer
    ): JsonResponse
    {
        $this->checkAuthorization($request, $login);

        $entryData = $getOne->__invoke($id);
           $normalizedData = $normalizer->normalize($entryData, null, [
               'circular_reference_handler' => function ($object) {
                   return $object->getId();
               },
               'ignored_attributes' => ['journal']
           ]);

        return $this->successResponse(
            $normalizedData,
            'Entry retrieved successfully'
        );

    }

}
