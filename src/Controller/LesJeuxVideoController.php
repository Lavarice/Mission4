<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JeuxVideoRepository;
use App\Repository\GenreRepository;
use App\Repository\PegiRepository;
use App\Repository\MarqueRepository;
use App\Repository\PlateformeRepository;

class LesJeuxVideoController extends AbstractController
{
    /**
     * @Route("/jeuxvideo", name="jeuxvideo_index")
     */
    public function index(
        JeuxVideoRepository $jeuxRepo,
        GenreRepository $genreRepo,
        PegiRepository $pegiRepo,
        MarqueRepository $marqueRepo,
        PlateformeRepository $plateformeRepo
    ): Response {
        return $this->render('lesJeuxVideo.html.twig', [
            'tbJeux' => $jeuxRepo->findAll(),
            'tbGenres' => $genreRepo->findAll(),
            'tbPegis' => $pegiRepo->findAll(),
            'tbMarques' => $marqueRepo->findAll(),
            'tbPlateformes' => $plateformeRepo->findAll(),
            'idJeuxModif' => -1,
            'idJeuxNotif' => -1,
            'notification' => 'rien',
        ]);
    }

    // Ajoutez ici les méthodes pour ajouter, modifier, supprimer, etc.
}
