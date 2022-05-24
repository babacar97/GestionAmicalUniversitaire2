<?php

namespace App\Controller;

use App\Entity\Campagne;
use App\Form\Campagne1Type;
use App\Repository\CampagneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/campagne")
 */
class CampagneController extends AbstractController
{
    /**
     * @Route("/", name="app_campagne_index", methods={"GET"})
     */
    public function index(CampagneRepository $campagneRepository): Response
    {
        return $this->render('campagne/index.html.twig', [
            'campagnes' => $campagneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_campagne_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CampagneRepository $campagneRepository): Response
    {
        $campagne = new Campagne();
        $form = $this->createForm(Campagne1Type::class, $campagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campagneRepository->add($campagne);
            return $this->redirectToRoute('app_campagne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campagne/new.html.twig', [
            'campagne' => $campagne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_campagne_show", methods={"GET"})
     */
    public function show(Campagne $campagne): Response
    {
        return $this->render('campagne/show.html.twig', [
            'campagne' => $campagne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_campagne_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Campagne $campagne, CampagneRepository $campagneRepository): Response
    {
        $form = $this->createForm(Campagne1Type::class, $campagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campagneRepository->add($campagne);
            return $this->redirectToRoute('app_campagne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campagne/edit.html.twig', [
            'campagne' => $campagne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_campagne_delete", methods={"POST"})
     */
    public function delete(Request $request, Campagne $campagne, CampagneRepository $campagneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$campagne->getId(), $request->request->get('_token'))) {
            $campagneRepository->remove($campagne);
        }

        return $this->redirectToRoute('app_campagne_index', [], Response::HTTP_SEE_OTHER);
    }
}
