<?php

namespace App\Controller;

use App\Entity\Plateformes;
use App\Form\PlateformesType;
use App\Repository\PlateformesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/plateformes')]
final class PlateformesController extends AbstractController
{
    #[Route(name: 'app_plateformes_index', methods: ['GET'])]
    public function index(PlateformesRepository $plateformesRepository): Response
    {
        return $this->render('plateformes/index.html.twig', [
            'plateformes' => $plateformesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plateformes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plateforme = new Plateformes();
        $form = $this->createForm(PlateformesType::class, $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plateforme);
            $entityManager->flush();

            return $this->redirectToRoute('app_plateformes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plateformes/new.html.twig', [
            'plateforme' => $plateforme,
            'form' => $form,
            'menuActif' => 'Jeux',
        ]);
    }

    #[Route('/{id}', name: 'app_plateformes_show', methods: ['GET'])]
    public function show(Plateformes $plateforme): Response
    {
        return $this->render('plateformes/show.html.twig', [
            'plateforme' => $plateforme,
            'menuActif' => 'Jeux',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plateformes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plateformes $plateforme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlateformesType::class, $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_plateformes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plateformes/edit.html.twig', [
            'plateforme' => $plateforme,
            'form' => $form,
            'menuActif' => 'Jeux',
        ]);
    }

    #[Route('/{id}', name: 'app_plateformes_delete', methods: ['POST'])]
    public function delete(Request $request, Plateformes $plateforme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plateforme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($plateforme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_plateformes_index', [], Response::HTTP_SEE_OTHER);
    }
}
