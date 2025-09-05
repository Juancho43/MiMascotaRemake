<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Application\Command\LocationSearchCommand;
use App\MiMascota\Locations\Domain\LocationRepository;

final readonly class LocationSearch
{
    public function __construct(private LocationRepository $repository)
    {

    }

    public function __invoke(LocationSearchCommand $command) : array
    {
        return $this->repository->search($command->search);
    }
}
