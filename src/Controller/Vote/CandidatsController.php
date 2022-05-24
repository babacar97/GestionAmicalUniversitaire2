<?php

namespace App\Controller;

use App\Entity\Candidats;
use App\Form\CandidatsType;
use App\Repository\CandidatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/candidats")
 */
class CandidatsController extends AbstractController
{
    /**
     * @Route("/", name="app_candidats_index", methods={"GET"})
     */
    public function index(CandidatsRepository $candidatsRepository): Response
    {
        return $this->render('candidats/index.html.twig', [
            'candidats' => $candidatsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_candidats_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CandidatsRepository $candidatsRepository): Response
    {
        $candidat = new Candidats();
        $form = $this->createForm(CandidatsType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidatsRepository->add($candidat);
            return $this->redirectToRoute('app_candidats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidats/new.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_candidats_show", methods={"GET"})
     */
    public function show(Candidats $candidat): Response
    {
        return $this->render('candidats/show.html.twig', [
            'candidat' => $candidat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_candidats_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Candidats $candidat, CandidatsRepository $candidatsRepository): Response
    {
        $form = $this->createForm(CandidatsType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidatsRepository->add($candidat);
            return $this->redirectToRoute('app_candidats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('candidats/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_candidats_delete", methods={"POST"})
     */
    public function delete(Request $request, Candidats $candidat, CandidatsRepository $candidatsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $candidat->getId(), $request->request->get('_token'))) {
            $candidatsRepository->remove($candidat);
        }

        return $this->redirectToRoute('app_candidats_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/programme", name="app_candidat_details", methods={"POST"})
     */
    public function detailsCandidats(Request $request, Candidats $candidat, CandidatsRepository $candidatsRepository)
    {

        return $this->render('gestion_vote/programmes.html.twig');
    }
}
