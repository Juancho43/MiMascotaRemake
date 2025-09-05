<?php

namespace App\MiMascota\Locations\Application;

use App\MiMascota\Locations\Application\Query\GetLocationByIdQuery;
use App\MiMascota\Locations\Domain\LocationRepository;
use App\MiMascota\Users\Domain\ValueObject\UserRole;

final readonly class SoftDeleteLocation
{
    public function __construct(private LocationRepository $repository, private LocationGetById $getById)
    {

    }

    public function __invoke(GetLocationByIdQuery $query) : void
    {
        $location = $this->getById->__invoke($query);
        $location->getSoftDelete()->markAsDeleted();
        $location->getTimeStamp()->update();
        $this->repository->save($location);

    }
}
