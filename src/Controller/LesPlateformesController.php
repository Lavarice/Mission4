<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlateformeRepository;

class LesPlateformesController extends AbstractController
{
    /**
     * @Route("/plateformes", name="plateformes_index")
     */
    public function index(PlateformeRepository $plateformeRepo): Response
    {
        return $this->render('lesPlateformes.html.twig', [
            'tbPlateformes' => $plateformeRepo->findAll(),
            'idPlateformeModif' => -1,
            'menuActif' => 'Jeux',
        ]);
    }

    // Ajoutez ici les méthodes pour ajouter, modifier, supprimer, etc.
}
