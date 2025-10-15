<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PegiRepository;

class LesPegisController extends AbstractController
{
    /**
     * @Route("/pegis", name="pegis_index")
     */
    public function index(PegiRepository $pegiRepo): Response
    {
        return $this->render('lesPegis.html.twig', [
            'tbPegis' => $pegiRepo->findAll(),
            'idPegiModif' => -1,
            'menuActif' => 'Jeux',
        ]);
    }

    // Ajoutez ici les méthodes pour ajouter, modifier, supprimer, etc.
}
