<?php
// src/Controller/PlateformesController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
require_once 'modele/class.PdoJeux.inc.php';
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use PdoJeux;

class PlateformesController extends AbstractController
{
    /**
     * Affiche la liste des plateformes
     */
    private function afficherPlateformes(PdoJeux $db, int $idPlateformeModif, string $notification = '')
    {
        $tbPlateformes = $db->getLesPlateformes();
        return $this->render('lesPlateformes.html.twig', [
            'menuActif' => 'Jeux',
            'tbPlateformes' => $tbPlateformes,
            'idPlateformeModif' => $idPlateformeModif,
            'notification' => $notification
        ]);
    }

    #[Route('/plateformes', name: 'plateformes_afficher')]
    public function index(SessionInterface $session)
    {
        if ($session->has('idUtilisateur')) {
            $db = PdoJeux::getPdoJeux();
            return $this->afficherPlateformes($db, -1);
        } else {
            return $this->render('connexion.html.twig');
        }
    }

    #[Route('/plateformes/ajouter', name: 'plateformes_ajouter')]
    public function ajouter(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $notification = '';
        if (!empty($request->request->get('txtLibPlateforme'))) {
            $db->ajouterPlateforme($request->request->get('txtLibPlateforme'));
            $notification = 'Ajoutée';
        }
        return $this->afficherPlateformes($db, -1, $notification);
    }

    #[Route('/plateformes/demandermodifier', name: 'plateformes_demandermodifier')]
    public function demanderModifier(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        return $this->afficherPlateformes($db, $request->request->get('txtIdPlateforme'));
    }

    #[Route('/plateformes/validermodifier', name: 'plateformes_validermodifier')]
    public function validerModifier(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $db->modifierPlateforme($request->request->get('txtIdPlateforme'), $request->request->get('txtLibPlateforme'));
        return $this->afficherPlateformes($db, -1, 'Modifiée');
    }

    #[Route('/plateformes/supprimer', name: 'plateformes_supprimer')]
    public function supprimer(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $db->supprimerPlateforme($request->request->get('txtIdPlateforme'));
        $this->addFlash('success', 'La plateforme a été supprimée');
        return $this->afficherPlateformes($db, -1);
    }
}
