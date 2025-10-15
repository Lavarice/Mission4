<?php
// src/Controller/MarquesController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
require_once 'modele/class.PdoMarque.inc.php';
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use PdoMarque;

class MarquesController extends AbstractController
{
    /**
     * fonction pour afficher la liste des marques
     */
    private function afficherMarques(int $idMarqueModif = -1, string $notification = '')
    {
        $tbMarques = PdoMarque::getLesMarques();
        return $this->render('lesMarques.html.twig', [
            'menuActif' => 'Jeux',
            'tbMarques' => $tbMarques,
            'idMarqueModif' => $idMarqueModif,
            'notification' => $notification
        ]);
    }

    #[Route('/marques', name: 'marques_afficher')]
    public function index(SessionInterface $session)
    {
        if ($session->has('idUtilisateur')) {
            return $this->afficherMarques(-1);
        } else {
            return $this->render('connexion.html.twig');
        }
    }

    #[Route('/marques/ajouter', name: 'marques_ajouter')]
    public function ajouter(SessionInterface $session, Request $request)
    {
        if (!empty($request->request->get('txtLibMarque'))) {
            PdoMarque::ajouterMarque($request->request->get('txtLibMarque'));
            return $this->afficherMarques(-1, 'Ajoutée');
        }
        return $this->afficherMarques(-1);
    }

    #[Route('/marques/demandermodifier', name: 'marques_demandermodifier')]
    public function demanderModifier(SessionInterface $session, Request $request)
    {
        return $this->afficherMarques($request->request->get('txtIdMarque'));
    }

    #[Route('/marques/validermodifier', name: 'marques_validermodifier')]
    public function validerModifier(SessionInterface $session, Request $request)
    {
        PdoMarque::modifierMarque($request->request->get('txtIdMarque'), $request->request->get('txtLibMarque'));
        return $this->afficherMarques(-1, 'Modifiée');
    }

    #[Route('/marques/supprimer', name: 'marques_supprimer')]
    public function supprimer(SessionInterface $session, Request $request)
    {
        PdoMarque::supprimerMarque($request->request->get('txtIdMarque'));
        $this->addFlash('success', 'La marque a été supprimée');
        return $this->afficherMarques(-1);
    }
}