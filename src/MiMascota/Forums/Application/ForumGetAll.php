<?php

namespace App\MiMascota\Forums\Application;

use App\MiMascota\Forums\Domain\ForumRepository;

class ForumGetAll
{
    public function __construct(private ForumRepository $repository)
    {
    }

    public function __invoke(): array
    {
        return $this->repository->getAll();
    }
}
