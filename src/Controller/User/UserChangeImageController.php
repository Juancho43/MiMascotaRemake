<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\UserChangeImage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserChangeImageController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;
    public function __construct(
        private UserChangeImage $userChangeImage
    ) {}
    #[Route('/user/image/change', name: 'user_change_image', methods: ['POST'])]
    public function __invoke(Request $request) : JsonResponse
    {
        $user = $this->checkAuthorization($request);
        $image = $this->userChangeImage->__invoke(
            $request->files->get('image'),
            $user->getId()
        );
        return $this->successResponse(
            data: $image,
            message: "Imagen de usuario actualizada correctamente"
        );
    }
}
