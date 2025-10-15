<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MarqueRepository;

class LesMarquesController extends AbstractController
{
    /**
     * @Route("/marques", name="marques_index")
     */
    public function index(MarqueRepository $marqueRepo): Response
    {
        return $this->render('lesMarques.html.twig', [
            'tbMarques' => $marqueRepo->findAll(),
            'idMarqueModif' => -1,
            'menuActif' => 'Jeux',
        ]);
    }

    // Ajoutez ici les méthodes pour ajouter, modifier, supprimer, etc.
}
