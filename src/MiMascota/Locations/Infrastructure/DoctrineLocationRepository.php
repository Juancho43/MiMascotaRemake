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

    public function findById(string $id): ?Location
    {
       return $this->findOneBy(['id' => $id]);
    }

    public function findByCords(string $latitude, string $longitude, string $city): ?Location
    {
       return $this->createQueryBuilder('location')
            ->select('location')
            ->where('location.latitude.value = :latitude AND location.longitude.value = :longitude')
           ->andWhere('location.softDelete.deletedAt IS NULL')
            ->orWhere('location.city.value = :city')
            ->setMaxResults(1)
            ->setParameter('latitude', $latitude)
            ->setParameter('longitude', $longitude)
            ->setParameter('city', $city)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getAll(int $page = 1, int $limit = 10): array
    {
        return $this->createQueryBuilder('location')
            ->select('location')
            ->andWhere('location.softDelete.deletedAt IS NULL')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('location.city.value', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findBySlug(string $slug): ?Location
    {
        return $this->createQueryBuilder('location')
            ->select('location')
            ->where('location.slug.value = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function search(string $query): array
    {
        return $this->createQueryBuilder('location')
            ->select('location')
            ->where('location.city.value LIKE :query')
            ->andWhere('location.softDelete.deletedAt IS NULL')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('location.city.value', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function delete(Location $location): void
    {
        // TODO: Implement delete() method.
    }
}
