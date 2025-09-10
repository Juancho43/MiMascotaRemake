<?php

namespace App\MiMascota\Users\Infrastructure;

use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;

final readonly class CheckToken
{
    public function __construct(private UserRepository $repository){

    }

    public function __invoke(string | null $token) : ?User
    {
        if ($token === null){
            return null;
        }
        $formatToken = self::format($token);
        $user = $this->repository->findByToken($formatToken);
        $userToken = $user->getTokenByTokenValue($formatToken);
        $userToken->checkExpired();
        return $user;
    }
    public static function format(string | null $header) : string
    {
        if ($header && str_starts_with($header, 'Bearer ')) {
            // Remover "Bearer " y hacer trim para espacios al inicio/final
            $token = trim(substr($header, 7));
            // Opcional: remover espacios internos si no deberían existir
            return str_replace(' ', '', $token);
        }
        return '';
    }

}
