<?php

namespace App\MiMascota\Images\Infrastructure;

use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineImageRepository extends ServiceEntityRepository implements ImageRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function search(string $id): ?Image
    {
        // TODO: Implement search() method.
    }

    public function save(Image $image): void
    {
        $this->getEntityManager()->persist($image);
        $this->getEntityManager()->flush();
    }

    public function remove(Image $image): void
    {
        // TODO: Implement remove() method.
    }
}
