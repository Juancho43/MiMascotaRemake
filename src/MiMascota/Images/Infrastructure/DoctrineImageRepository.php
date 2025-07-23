<?php

namespace App\MiMascota\Images\Infrastructure;

use App\MiMascota\Animals\Domain\Animal;
use App\MiMascota\Entries\Domain\Entry;
use App\MiMascota\Images\Domain\AnimalImage;
use App\MiMascota\Images\Domain\EntryImage;
use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageRepository;
use App\MiMascota\Images\Domain\UserImage;
use App\MiMascota\Users\Domain\User;
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
        return $this->findOneBy(['id' => $id]);
    }

    public function save(Image $image): void
    {
        $this->getEntityManager()->persist($image);
        $this->getEntityManager()->flush();
    }

    public function remove(Image $image): void
    {
        $this->getEntityManager()->remove($image);
        $this->getEntityManager()->flush();
    }

    public function getFromAnimalImage(string $id, string $animalId): ?AnimalImage
    {
        return $this->createQueryBuilder('i')
            ->where('i.id = :id')
            ->andWhere('i.imageableId = :imageable_id')
            ->andWhere('i.imageableType = :type')
            ->setParameter('id', $id)
            ->setParameter('imageable_id', $animalId)
            ->setParameter('type', Animal::class)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getFromEntryImage(string $id, string $entryId): ?EntryImage
    {
        return $this->createQueryBuilder('i')
            ->where('i.id = :id')
            ->andWhere('i.imageableId = :imageable_id')
            ->andWhere('i.imageableType = :type')
            ->setParameter('id', $id)
            ->setParameter('imageable_id', $entryId)
            ->setParameter('type', Entry::class)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getFromUserImage(string $id, string $userId): ?UserImage
    {
        return $this->createQueryBuilder('i')
            ->where('i.id = :id')
            ->andWhere('i.imageableId = :imageable_id')
            ->andWhere('i.imageableType = :type')
            ->setParameter('id', $id)
            ->setParameter('imageable_id', $userId)
            ->setParameter('type', User::class)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
