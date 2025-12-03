<?php

namespace App\Controller;

use App\Entity\JeuVideo;
use App\Form\JeuVideoType;
use App\Repository\JeuVideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/jeuvideo')]
class JeuVideoController extends AbstractController
{
    public function __construct(
        private JeuVideoRepository $jeuVideoRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'app_jeuvideo_index', methods: ['GET'])]
    public function index(): Response
    {
        $jeux = $this->jeuVideoRepository->findAll();

        return $this->render('jeuvideo/index.html.twig', [
            'jeux' => $jeux,
            'menuActif' => 'Jeux',
        ]);
    }

    #[Route('/new', name: 'app_jeuvideo_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $jeu = new JeuVideo();
        $form = $this->createForm(JeuVideoType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->jeuVideoRepository->save($jeu, true);

            return $this->redirectToRoute('app_jeuvideo_index');
        }

        return $this->render('jeuvideo/new.html.twig', [
            'form' => $form,
            'menuActif' => 'Jeux',
        ]);
    }

    #[Route('/{refJeu}', name: 'app_jeuvideo_show', methods: ['GET'])]
    public function show(#[MapEntity(mapping: ['refJeu' => 'refJeu'])] JeuVideo $jeu): Response
    {
        return $this->render('jeuvideo/show.html.twig', [
            'jeu' => $jeu,
            'menuActif' => 'Jeux',
        ]);
    }

    #[Route('/{refJeu}/edit', name: 'app_jeuvideo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, #[MapEntity(mapping: ['refJeu' => 'refJeu'])] JeuVideo $jeu): Response
    {
        $form = $this->createForm(JeuVideoType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->jeuVideoRepository->save($jeu, true);

            return $this->redirectToRoute('app_jeuvideo_show', ['refJeu' => $jeu->getRefJeu()]);
        }

        return $this->render('jeuvideo/edit.html.twig', [
            'jeu' => $jeu,
            'form' => $form,
            'menuActif' => 'Jeux',
        ]);
    }

    #[Route('/{refJeu}', name: 'app_jeuvideo_delete', methods: ['POST'])]
    public function delete(Request $request, #[MapEntity(mapping: ['refJeu' => 'refJeu'])] JeuVideo $jeu): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jeu->getRefJeu(), $request->getPayload()->get('_token'))) {
            $this->jeuVideoRepository->remove($jeu, true);
        }

        return $this->redirectToRoute('app_jeuvideo_index');
    }
}
