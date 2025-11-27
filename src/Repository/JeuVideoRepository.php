<?php

namespace App\Repository;

use App\Entity\JeuVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JeuVideo>
 */
class JeuVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JeuVideo::class);
    }

    /**
     * @return JeuVideo[] Returns an array of JeuVideo objects
     */
    public function findAll(): array
    {
        return $this->findBy([], ['nom' => 'ASC']);
    }

    public function save(JeuVideo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JeuVideo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
