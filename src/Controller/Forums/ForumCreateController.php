<?php

namespace App\Controller\Forums;

use App\MiMascota\Forums\Application\Command\CreateForumCommand;
use App\MiMascota\Forums\Application\DTO\ForumResponse;
use App\MiMascota\Forums\Application\ForumCreator;
use App\MiMascota\Shared\ApiResponseTrait;
use App\MiMascota\Shared\AuthorizationCheckerTrait;
use App\MiMascota\Users\Domain\ValueObject\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumCreateController extends AbstractController
{
    use ApiResponseTrait, AuthorizationCheckerTrait;

    #[Route('/forums/create', name: 'app_forum_create', methods: ['POST'])]
    public function __invoke(Request $request, ForumCreator $creator): Response
    {
        try {
            $user = $this->checkAuthorization($request);
            if ($user->getRole()->getRole() !== UserRole::ADMIN && $user->getRole()->getRole() !== UserRole::MODERATOR) {
                throw new \Exception('You do not have permission to create a forum');
        }
            $data = $request->toArray();
            $command = new CreateForumCommand($data['name'],$data['description']);
            $response = $creator->__invoke($command);
            return $this->successResponse(ForumResponse::generate($response),'Forum created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


}
