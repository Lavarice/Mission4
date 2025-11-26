<?php
// src/Controller/PegisController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
require_once 'modele/class.PdoJeux.inc.php';
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use PdoJeux;

class PegisController extends AbstractController
{
    private function afficherPegis(PdoJeux $db, int $idPegiModif = -1, string $notification = '')
    {
        $tbPegis = $db->getPegi();
        return $this->render('lesPegis.html.twig', [
            'menuActif' => 'Jeux',
            'tbPegis' => $tbPegis,
            'idPegiModif' => $idPegiModif,
            'notification' => $notification
        ]);
    }

    #[Route('/pegis', name: 'pegis_afficher')]
    public function index(SessionInterface $session)
    {
        if ($session->has('idUtilisateur')) {
            $db = PdoJeux::getPdoJeux();
            return $this->afficherPegis($db, -1);
        } else {
            return $this->render('connexion.html.twig');
        }
    }

    #[Route('/pegis/ajouter', name: 'pegis_ajouter')]
    public function ajouter(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        if (!empty($request->request->get('txtAgeLimite')) || !empty($request->request->get('txtDescPegi'))) {
            $db->ajouterPegi($request->request->get('txtAgeLimite'), $request->request->get('txtDescPegi'));
            return $this->afficherPegis($db, -1, 'Ajouté');
        }
        return $this->afficherPegis($db, -1);
    }

    #[Route('/pegis/demandermodifier', name: 'pegis_demandermodifier')]
    public function demanderModifier(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        return $this->afficherPegis($db, $request->request->get('txtIdPegi'));
    }

    #[Route('/pegis/validermodifier', name: 'pegis_validermodifier')]
    public function validerModifier(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $db->modifierPegi(
            $request->request->get('txtIdPegi'),
            $request->request->get('txtAgeLimite'),
            $request->request->get('txtDescPegi')
        );
        return $this->afficherPegis($db, -1, 'Modifié');
    }

    #[Route('/pegis/supprimer', name: 'pegis_supprimer')]
    public function supprimer(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $db->supprimerPegi($request->request->get('txtIdPegi'));
        $this->addFlash('success', 'Le PEGI a été supprimé');
        return $this->afficherPegis($db, -1);
    }
}