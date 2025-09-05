<?php

namespace App\Controller\User;

use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Application\Command\EditUserCommand;
use App\MiMascota\Users\Application\DTO\UserResponse;
use App\MiMascota\Users\Application\UserEdit;
use App\MiMascota\Users\Domain\ValueObject\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserEditController extends AbstractController
{
    use ApiResponseTrait,AuthorizationCheckerTrait;

    #[Route('/user/edit', name: 'user_edit', methods: ['PUT'])]
    public function __invoke(Request $request, UserEdit $app) : Response
    {
        try {
            $user = $this->checkAuthorization($request);
            $data = $request->toArray();
            $role = UserRole::USER;
            $email = $data['email'];
            if ($user->getRole()->getRole() === UserRole::ADMIN) {
                $role = $data['role'] ;
                $email =  $data['email'] ?? $user->getEmail();
            }
            $command = new EditUserCommand(
                $user->getId(),
                $data['name'] ?? $user->getName(),
                $email,
                $data['telephone'] ?? $user->getTelephone(),
                $role,
                $data['latitude'] ?? $request->get('latitude'),
                $data['longitude'] ?? $request->get('longitude')
            );
            $data = $app->__invoke($command);
           return $this->successResponse(UserResponse::generate($data),'User updated successfully');
        }catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
