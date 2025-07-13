<?php

namespace App\Controller\Journal;

use App\MiMascota\Journals\Domain\JournalRepository;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Infrastructure\IsUserLoggedIn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JournalGetController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;

    #[Route('/journal/{id}', name: 'journal_get', methods: ['GET'])]
    public function __invoke(
        Request             $request,
        IsUserLoggedIn      $login,
        string              $id,
        JournalRepository   $repository,
        NormalizerInterface $normalizer
    ): JsonResponse
    {
        $this->checkAuthorization($request, $login);

        $data = $repository->getOneById($id);
        $normalizedData = $normalizer->normalize($data, null, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ]);

        return $this->successResponse(
            $normalizedData,
            'Journal retrieved successfully'
        );

    }
}
