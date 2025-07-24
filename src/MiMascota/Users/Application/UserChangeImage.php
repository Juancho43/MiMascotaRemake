<?php

namespace App\MiMascota\Users\Application;

use App\MiMascota\Images\Application\SaveImage;
use App\MiMascota\Images\Domain\UserImage;
use App\MiMascota\Users\Domain\UserRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class UserChangeImage
{

    public function __construct(
        private UserRepository $userRepository,
        private SaveImage $saveImage,
    )
    {

    }

    public function __invoke(
        UploadedFile $imageFile,
        string $userId
    ) :? UserImage
    {

        $user = $this->userRepository->search($userId);
        if ($user === null) {
            throw new \Exception("User not found");
        }
        $image = $this->saveImage->__invoke(
            $imageFile,
            'user',
            $userId,
        );
        $user_image = UserImage::create(Uuid::uuid4()->toString(), $user, $image, 1);
        $user->setImage($user_image);
        $this->userRepository->save($user);
        return $user->getImage();
    }
}
