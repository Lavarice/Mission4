<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TournoiRepository;

use App\Repository\CatTournoiRepository;

class TournoiStatController extends AbstractController
{
    #[Route('/statTournoi', name: 'app_stat_tournoi_index')]
    public function index(Request $request, TournoiRepository $tournoiRepository, CatTournoiRepository $catTournoiRepository): Response
    {
        $categorieId = $request->query->get('categorie');

        if ($categorieId) {
            $tournois = $tournoiRepository->findBy(['catTournoi' => $categorieId]);
        } else {
            $tournois = $tournoiRepository->findAll();
        }

        // Construction d'un tableau de données à envoyer à la vue
        $stats = [];
        foreach ($tournois as $tournoi) {
            $stats[] = [
                'libelle' => $tournoi->getNom(),
                'categorie' => $tournoi->getCatTournoi() ? $tournoi->getCatTournoi()->getNom() : '(catégorie inconnue)',
                'nbParticipants' => count($tournoi->getParticipants()),
            ];
        }

        $categories = $catTournoiRepository->findAll();

        // Envoi des données à la vue
        return $this->render('tournoi_stat/index.html.twig', [
            'stats' => $stats,
            'categories' => $categories,
            'selectedCategorie' => $categorieId,
            'menuActif' => 'Tournois',
        ]);
    }
}
