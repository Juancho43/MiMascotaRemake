<?php

namespace App\MiMascota\Forums\Infrastructure;

use App\MiMascota\Forums\Domain\Forum;
use App\MiMascota\Forums\Domain\ForumRepository;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 */
class DoctrineForumRepository extends ServiceEntityRepository implements ForumRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forum::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function search(string $id): ?Forum
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function save(Forum $forum): void
    {
        $this->getEntityManager()->persist($forum);
        $this->getEntityManager()->flush();
    }
    public function remove(Forum $forum): void
    {
        $this->getEntityManager()->remove($forum);
        $this->getEntityManager()->flush();
    }

    public function getBySlug(string $slug): ?Forum
    {
        return $this->createQueryBuilder('forum')
            ->where('forum.slug.value = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function getAll(): array
    {
       return $this->createQueryBuilder('forum')
           ->where('forum.softDelete.deletedAt IS NULL')
           ->orderBy('forum.timeStamp.createdAt', 'ASC')
           ->getQuery()
           ->getResult();
    }

    public function getPostCountBySlug($slug): int
    {
       return $this->createQueryBuilder('forum')
            ->select('COUNT(post.id)')
            ->leftJoin('forum.posts', 'post')
            ->where('forum.slug.value = :slug')
            ->andWhere('post.softDelete.deletedAt IS NULL')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
