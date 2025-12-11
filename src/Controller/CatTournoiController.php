<?php

namespace App\Controller;

use App\Entity\CatTournoi;
use App\Form\CatTournoiType;
use App\Repository\CatTournoiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cat/tournoi')]
class CatTournoiController extends AbstractController
{
    #[Route('/', name: 'app_cat_tournoi_index', methods: ['GET'])]
    public function index(CatTournoiRepository $catTournoiRepository): Response
    {
        return $this->render('cat_tournoi/index.html.twig', [
            'cat_tournois' => $catTournoiRepository->findAll(),
            'menuActif' => 'Tournois',
        ]);
    }

    #[Route('/new', name: 'app_cat_tournoi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CatTournoiRepository $catTournoiRepository): Response
    {
        $catTournoi = new CatTournoi();
        $form = $this->createForm(CatTournoiType::class, $catTournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $catTournoiRepository->save($catTournoi, true);

            return $this->redirectToRoute('app_cat_tournoi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cat_tournoi/new.html.twig', [
            'cat_tournoi' => $catTournoi,
            'form' => $form->createView(),
            'menuActif' => 'Tournois',
        ]);
    }

    #[Route('/{id}', name: 'app_cat_tournoi_show', methods: ['GET'])]
    public function show(CatTournoi $catTournoi): Response
    {
        return $this->render('cat_tournoi/show.html.twig', [
            'cat_tournoi' => $catTournoi,
            'menuActif' => 'Tournois',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cat_tournoi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CatTournoi $catTournoi, CatTournoiRepository $catTournoiRepository): Response
    {
        $form = $this->createForm(CatTournoiType::class, $catTournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $catTournoiRepository->save($catTournoi, true);

            return $this->redirectToRoute('app_cat_tournoi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cat_tournoi/edit.html.twig', [
            'cat_tournoi' => $catTournoi,
            'form' => $form->createView(),
            'menuActif' => 'Tournois',
        ]);
    }

    #[Route('/{id}', name: 'app_cat_tournoi_delete', methods: ['POST'])]
    public function delete(Request $request, CatTournoi $catTournoi, CatTournoiRepository $catTournoiRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catTournoi->getId(), $request->request->get('_token'))) {
            $catTournoiRepository->remove($catTournoi, true);
        }

        return $this->redirectToRoute('app_cat_tournoi_index', [], Response::HTTP_SEE_OTHER);
    }
}
