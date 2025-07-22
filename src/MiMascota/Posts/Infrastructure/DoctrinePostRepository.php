<?php

namespace App\MiMascota\Posts\Infrastructure;

use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Posts\Domain\PostRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

class DoctrinePostRepository extends ServiceEntityRepository implements PostRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }


    public function getBySlug(string $slug): ?Post
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    public function search(string $id): ?Post
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function save(Post $post): void
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }

    public function remove(Post $post): void
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }
    public function getByForumSlug(string $slug, int $page, int $limit): array
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'f')
            ->join('p.forum', 'f')
            ->where('f.slug = :slug')
             ->andWhere('p.softDelete.deletedAt IS NULL')
            ->setParameter('slug', $slug)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('p.timeStamp.createdAt', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }

  public function getByForumFilterLocation(string $forumSlug, string $locationId, int $page, int $limit): array
  {
      return $this->createQueryBuilder('p')
          ->select('p', 'f')
          ->join('p.forum', 'f')
          ->where('f.slug = :forumSlug')
          ->andWhere('p.locationId = :locationId')
          ->andWhere('p.softDelete.deletedAt IS NULL')
          ->setParameter('forumSlug', $forumSlug)
          ->setParameter('locationId', $locationId)
          ->setFirstResult(($page - 1) * $limit)
          ->setMaxResults($limit)
          ->orderBy('p.timeStamp.createdAt', 'DESC')
          ->getQuery()
          ->getArrayResult();
  }

    public function getSoftDeletedPosts(int $page, int $limit): array
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'f')
            ->join('p.forum', 'f')
            ->andWhere('p.softDelete.deletedAt IS NOT NULL')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('p.softDelete.deletedAt', 'DESC')
            ->getQuery()
            ->getArrayResult();

    }

    public function getSoftDeletedPostsByForum(string $forumSlug, int $page, int $limit): array
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'f')
            ->join('p.forum', 'f')
            ->where('f.slug = :forumSlug')
            ->andWhere('p.softDelete.deletedAt IS NOT NULL')
            ->setParameter('forumSlug', $forumSlug)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('p.softDelete.deletedAt', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }
}
