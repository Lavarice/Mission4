<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TournoisController extends AbstractController
{
    #[Route('/tournois', name: 'app_tournois')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_tournoi_index');
    }
}
