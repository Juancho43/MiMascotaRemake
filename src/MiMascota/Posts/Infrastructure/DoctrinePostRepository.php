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
            ->where('f.slug.value = :slug')
            ->andWhere('p.softDelete.deletedAt IS NULL')
            ->andWhere('f.softDelete.deletedAt IS NULL')
            ->andWhere('p.reported.reportedAt IS NULL')

            ->setParameter('slug', $slug)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('p.timeStamp.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

  public function getByForumFilterLocation(string $forumSlug, string $locationSlug, int $page, int $limit): array
  {
      return $this->createQueryBuilder('p')
          ->select('p', 'f')
          ->join('p.forum', 'f')
          ->join('p.location', 'l')
          ->where('f.slug.value = :forumSlug')
          ->andWhere('l.slug.value = :locationSlug')
          ->andWhere('p.reported.reportedAt IS NULL')
          ->andWhere('p.softDelete.deletedAt IS NULL')
          ->setParameter('forumSlug', $forumSlug)
          ->setParameter('locationSlug', $locationSlug)
          ->setFirstResult(($page - 1) * $limit)
          ->setMaxResults($limit)
          ->orderBy('p.timeStamp.createdAt', 'DESC')
          ->getQuery()
          ->getResult();
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

    public function getByUserId(string $userId, int $page, int $limit): array
    {
        return $this->createQueryBuilder('posts')
            ->join('posts.user', 'user')
            ->where('user.id = :userId')
            ->andWhere('posts.softDelete.deletedAt IS NULL')
            ->setParameter(':userId',$userId)
           ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('posts.timeStamp.createdAt', 'DESC')

            ->getQuery()
            ->getResult();
    }
}
