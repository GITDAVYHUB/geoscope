<?php

namespace App\Controller;

use App\Entity\Interventions;
use App\Entity\Intervention;
use App\Form\InterventionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\InterventionsRepository;
use App\Form\InterventionsType;

final class InterventionsController extends AbstractController
{
   #[Route("/interventions", name:"interventions_index")]
    public function index(InterventionsRepository $interventionsRepository): Response
    {
        $interventions = $interventionsRepository->findAll();
        return $this->render('interventions/index.html.twig', [
             'interventions' => $interventions,
        ]);
    }

    #[Route("/interventions/{id}", name:"interventions_show")]
    public function show(Interventions $interventions): Response
    {
        if (!$interventions) {
           throw $this->createNotFoundException('Interventions non trouvée.');
        }
        return $this->render('interventions/show.html.twig', [
           'interventions' => $interventions,
        ]);
    }
    #[Route("/interventions/{id}/delete", name:"interventions_delete", methods: ["POST"])]
    public function delete(Request $request, Interventions $interventions, InterventionsRepository $interventionsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$interventions->getId(), $request->request->get('_token'))) {
            $interventionsRepository->remove($interventions, true);
            $this->addFlash('success', 'Interventions deleted successfully.');
            return $this->redirectToRoute('interventions_index');
        } else {
            $this->addFlash('error', 'Invalid CSRF token.');
            return $this->redirectToRoute('interventions_show', ['id' => $interventions->getId()]);
        }
    }
    #[Route("/interventions/create", name:"interventions_create", methods: ["GET", "POST"])]
    public function create(Request $request, InterventionsRepository $interventionsRepository): Response
    {
        $intervention = new Interventions();
        $form = $this->createForm(InterventionsType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interventionsRepository->add($intervention, true);
            $this->addFlash('success', 'Intervention created successfully.');
            return $this->redirectToRoute('interventions_index');
        }

        return $this->render('intervention/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/interventions/{id}/edit", name:"interventions_edit", methods: ["GET", "POST"])]
    public function edit(Request $request, Interventions $interventions, InterventionsRepository $interventionsRepository): Response
    {
        $form = $this->createForm(InterventionsType::class, $interventions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interventionsRepository->add($interventions, true);
            $this->addFlash('success', 'Interventions updated successfully.');
            return $this->redirectToRoute('interventions_index');
        }

        return $this->render('interventions/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/interventions/filtrer", name:"interventions_filtrer")]
    public function filtrer(Request $request, InterventionsRepository $interventionsRepository): Response
    {
        $technicien = $request->query->get('technicien');
        $etat = $request->query->get('etat');
        $criteria = [];
        if ($technicien) {
            $criteria['technicien'] = $technicien;
        }
        if ($etat) {
            $criteria['etat'] = $etat;
        }
        $interventions = $interventionsRepository->findBy($criteria);

        return $this->render('interventions/index.html.twig', [
            'interventions' => $interventions,
        ]);
    }
    
    #[Route("/interventions/{id}/print", name:"interventions_print")]
    public function print(Interventions $interventions): Response
    {
        return $this->render('interventions/print.html.twig', [
            'interventions' => $interventions,
        ]);
    }

    #[Route("/", name:"home")]
    public function home(): Response
    {
    return $this->render('home.html.twig');
    }
}    