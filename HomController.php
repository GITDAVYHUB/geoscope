<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomController extends AbstractController
{
    #[Route('/hom', name: 'app_hom')]
    public function index(): Response
    {
        return $this->render('hom/index.html.twig', [
            'controller_name' => 'HomController',
        ]);
    }
}
