<?php

namespace App\Controller;

use App\Entity\Composition;
use App\Form\CompositionType;
use App\Repository\CompositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/composition")
 */
class CompositionController extends AbstractController
{
    /**
     * @Route("/", name="composition_index", methods={"GET"})
     */
    public function index(CompositionRepository $compositionRepository): Response
    {
        return $this->render('composition/index.html.twig', [
            'compositions' => $compositionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="composition_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $composition = new Composition();
        $form = $this->createForm(CompositionType::class, $composition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($composition);
            $entityManager->flush();

            return $this->redirectToRoute('composition_index');
        }

        return $this->render('composition/new.html.twig', [
            'composition' => $composition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="composition_show", methods={"GET"})
     */
    public function show(Composition $composition): Response
    {
        return $this->render('composition/show.html.twig', [
            'composition' => $composition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="composition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Composition $composition): Response
    {
        $form = $this->createForm(CompositionType::class, $composition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('composition_index', [
                'id' => $composition->getId(),
            ]);
        }

        return $this->render('composition/edit.html.twig', [
            'composition' => $composition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="composition_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Composition $composition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$composition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($composition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('composition_index');
    }
}
