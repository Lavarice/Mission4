<?php
// src/Controller/LesJeuxVideo.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
require_once 'modele/class.PdoJeux.inc.php';
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use PdoJeux;

class LesJeuxVideoController extends AbstractController
{
    private function afficherJeux(PdoJeux $db, ?string $idJeuxModif, ?string $idJeuxNotif, string $notification)
    {
        $tbGenres = $db->getLesGenres();
        $tbPegis = $db->getLesPegis();
        $tbMarques = $db->getLesMarques();
        $tbPlateformes = $db->getPlateformes();
        $tbJeux = $db->getLesJeuxVideo();

        return $this->render('lesJeuxVideo.html.twig', [
            'tbJeux' => $tbJeux,
            'tbGenres' => $tbGenres,
            'tbPegis' => $tbPegis,
            'tbMarques' => $tbMarques,
            'tbPlateformes' => $tbPlateformes,
            'idJeuxModif' => $idJeuxModif,
            'idJeuxNotif' => $idJeuxNotif,
            'notification' => $notification
        ]);
    }

    #[Route('/jeuxvideo', name: 'jeuxvideo_afficher')]
    public function index(SessionInterface $session)
    {
        if ($session->has('idUtilisateur')) {
            $db = PdoJeux::getPdoJeux();
            return $this->afficherJeux($db, -1, -1, 'rien');
        } else {
            return $this->render('connexion.html.twig');
        }
    }

    #[Route('/jeuxvideo/ajouter', name: 'jeuxvideo_ajouter')]
    public function ajouter(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $notification = 'rien';
        $idJeuxNotif = -1;
        if (!empty($request->request->get('txtNom')) && !empty($request->request->get('txtPrix'))) {
            $db->ajouterJeu(
                $request->request->get('txtNom'),
                $request->request->get('txtPrix'),
                $request->request->get('txtDateParution'),
                $request->request->get('lstPegi'),
                $request->request->get('lstPlateforme'),
                $request->request->get('lstMarque'),
                $request->request->get('lstGenre')
            );
            $notification = 'Ajouté';
        }
        return $this->afficherJeux($db, -1, $idJeuxNotif, $notification);
    }

    #[Route('/jeuxvideo/demandermodifier', name: 'jeuxvideo_demandermodifier')]
    public function demanderModifier(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $id = $request->request->get('txtIdJeux');
        return $this->afficherJeux($db, $id, null, 'rien');
    }

    #[Route('/jeuxvideo/validermodifier', name: 'jeuxvideo_validermodifier')]
    public function validerModifier(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $db->modifierJeu(
            $request->request->get('txtIdJeux'),
            $request->request->get('txtNom'),
            $request->request->get('txtPrix'),
            $request->request->get('txtDateParution'),
            $request->request->get('lstPegi'),
            $request->request->get('lstPlateforme'),
            $request->request->get('lstMarque'),
            $request->request->get('lstGenre')
        );
    $idNotif = $request->request->get('txtIdJeux');
    return $this->afficherJeux($db, null, $idNotif, 'Modifié');
    }

    #[Route('/jeuxvideo/supprimer', name: 'jeuxvideo_supprimer')]
    public function supprimer(SessionInterface $session, Request $request)
    {
        $db = PdoJeux::getPdoJeux();
        $db->supprimerJeu($request->request->get('txtIdJeux'));
        $this->addFlash('success', 'Le jeu vidéo a été supprimé');
        return $this->afficherJeux($db, -1, -1, 'rien');
    }
}       
    
