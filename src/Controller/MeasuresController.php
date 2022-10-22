<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Measures;
use App\Entity\Localisation;
use App\Form\MeasuresType;
use App\Repository\MeasuresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/measures')]
class MeasuresController extends AbstractController
{
    #[Route('/', name: 'app_measures_index', methods: ['GET'])]
    public function index(MeasuresRepository $measuresRepository): Response
    {
        return $this->render('measures/index.html.twig', [
            'measures' => $measuresRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_measures_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $measure = new Measures();
        $form = $this->createForm(MeasuresType::class, $measure, [
            'validation_groups' => [
                'edit',
                'new',
                ]
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($measure);
            $entityManager->flush();

            return $this->redirectToRoute('app_measures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('measures/new.html.twig', [
            'measure' => $measure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measures_show', methods: ['GET'])]
    public function show(Measures $measure): Response
    {
        return $this->render('measures/show.html.twig', [
            'measure' => $measure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_measures_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Measures $measure, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeasuresType::class, $measure, [
            'validation_groups' => [
                'edit',
                'new',
                ]
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_measures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('measures/edit.html.twig', [
            'measure' => $measure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measures_delete', methods: ['POST'])]
    public function delete(Request $request, Measures $measure, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$measure->getId(), $request->request->get('_token'))) {
            $entityManager->remove($measure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_measures_index', [], Response::HTTP_SEE_OTHER);
    }
}
