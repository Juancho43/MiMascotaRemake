<?php

namespace App\MiMascota\Locations\Infrastructure;

use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Locations\Domain\LocationRepository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Location>
 *
 */
class DoctrineLocationRepository extends ServiceEntityRepository implements LocationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }
    public function save(Location $location): void
    {
        $this->getEntityManager()->persist($location);
        $this->getEntityManager()->flush();
    }

    public function search(string $id): ?Location
    {
        return $this->getEntityManager()->find(Location::class, $id);
    }

    public function findByCords(string $latitude, string $longitude, string $city): ?Location
    {
       return $this->createQueryBuilder('location')
            ->select('location')
            ->where('location.latitude = :latitude AND location.longitude = :longitude')
            ->orWhere('location.city = :city')
            ->setMaxResults(1)
            ->setParameter('latitude', $latitude)
            ->setParameter('longitude', $longitude)
            ->setParameter('city', $city)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
