<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TournoiRepository;

class TournoiStatController extends AbstractController
{
    #[Route('/statTournoi', name: 'app_stat_tournoi_index')]
    public function index(TournoiRepository $tournoiRepository): Response
    {
        // Récupération de tous les tournois
        $tournois = $tournoiRepository->findAll();

        // Construction d'un tableau de données à envoyer à la vue
        $stats = [];
        foreach ($tournois as $tournoi) {
            $stats[] = [
                'libelle' => $tournoi->getNom(),
                'categorie' => $tournoi->getCatTournoi() ? $tournoi->getCatTournoi()->getLibelle() : '(catégorie inconnue)',
            ];
        }

        // Envoi des données à la vue
        return $this->render('tournoi_stat/index.html.twig', [
            'stats' => $stats,
            'menuActif' => 'Tournois',
        ]);
    }
}
