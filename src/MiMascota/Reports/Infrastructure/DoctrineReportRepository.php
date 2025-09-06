<?php

namespace App\MiMascota\Reports\Infrastructure;

use App\MiMascota\Reports\Domain\Report;
use App\MiMascota\Reports\Domain\ReportRepository;
use App\MiMascota\Users\Domain\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineReportRepository extends ServiceEntityRepository implements ReportRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function save(Report $reports) : void
    {
        $this->getEntityManager()->persist($reports);
        $this->getEntityManager()->flush();
    }

    public function findById(string $id): ?Report
    {
        return $this->createQueryBuilder('report')
            ->where('report.id : id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('report')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function delete(Report $report): void
    {
        $this->getEntityManager()->remove($report);
        $this->getEntityManager()->flush();
    }

    public function findByForumAndLocation(string $forumSlug, string $locationSlug, int $page, int $limit): array
    {
       return $this->createQueryBuilder('report')
           ->join('report.reportedPost', 'post')
           ->join('post.forum', 'forum')
           ->join('post.location', 'location')
           ->where('forum.slug.value = :forumSlug')
           ->andWhere('location.slug.value = :locationSlug')
           ->setParameter('forumSlug', $forumSlug)
           ->setParameter('locationSlug', $locationSlug)
           ->setFirstResult(($page - 1) * $limit)
           ->setMaxResults($limit)
           ->getQuery()
           ->getResult();
    }
}
