<?php

namespace App\MiMascota\ContactRequests\Infrastructure;

use App\MiMascota\ContactRequests\Domain\ContactRequest;
use App\MiMascota\ContactRequests\Domain\ContactRequestRepository;
use App\MiMascota\Reports\Domain\Report;
use App\MiMascota\Reports\Domain\ReportRepository;
use App\MiMascota\Users\Domain\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineContactRequestRepository extends ServiceEntityRepository implements ContactRequestRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactRequest::class);
    }

    public function save(ContactRequest $contactRequest) : void
    {
        $this->getEntityManager()->persist($contactRequest);
        $this->getEntityManager()->flush();
    }

    public function findById(string $id): ?ContactRequest
    {
        return $this->createQueryBuilder('cr')
            ->where('report.id : id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function findByRequesterId(string $id): array
    {
        return $this->createQueryBuilder('cr')
            ->where('cr.requester = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findByOwnerId(string $id): array
    {
        return $this->createQueryBuilder('cr')
            ->where('cr.owner = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
