<?php

namespace App\Repository;

use App\Entity\Tournoi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tournoi>
 */
class TournoiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournoi::class);
    }

    /**
     * @return Tournoi[]
     */
    public function findAllAfterThanDateSQL($datemax): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM tournoi t
                WHERE t.date_debut >= :datemax
                ORDER BY t.date_debut ASC';
        $stmt = $conn->prepare($sql);
        $resultat = $stmt->executeQuery(['datemax' => $datemax]);

        return $resultat->fetchAllNumeric();
    }

    /**
     * @return Tournoi[]
     */
    public function findAllAfterThanDateDQL($datemax): array
    {
        $entityManager = $this->getEntityManager();

        // ce n'est pas du SQL mais du DQL : Doctrine Query Language
        // il s'agit en fait d'une requête classique mais qui référence l'objet au lieu de la table
        $query = $entityManager->createQuery(
            'SELECT t
            FROM App\Entity\Tournoi t
            WHERE t.dateDebut >= :datemax
            ORDER BY t.dateDebut ASC'
        )->setParameter('datemax', $datemax);

        // retourne un tableau d'objets de type Tournoi
        return $query->getResult();
    }

    /**
     * @return Tournoi[]
     */
    public function findAllAfterThanDateQB($datemax): array
    {
        // ce n'est pas du SQL mais QueryBuilder
        $qb = $this->createQueryBuilder('t')
            ->where('t.dateDebut >= :datemax')
            ->setParameter('datemax', $datemax)
            ->orderBy('t.dateDebut', 'ASC');
        $query = $qb->getQuery();

        // retourne un tableau d'objets de type Tournoi
        return $query->getResult();
    }
}
