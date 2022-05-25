<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vote;
use App\Form\VoteType;
use App\Repository\UserRepository;
use App\Repository\CandidatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GestionVoteController extends AbstractController
{
    /**
     * @Route("/gestion/vote", name="app_gestion_vote")
     */
    public function index(CandidatsRepository $candidatsRepository, UserRepository $userRepository): Response
    {
        $candidats = $candidatsRepository->findAll();
        $user = $userRepository->findAll();


        return $this->render('gestion_vote/liste.html.twig', [
            'controller_name' => 'GestionVoteController',
            'listeCandidats' => $candidats,
            'user' => $user
        ]);
    }

    // /**
    //  * @Route("/EngistrementVote", name="app_EngistrementVote")
    //  */
    // public function EngistrementVote(): Response
    // {
    //     return $this->render('gestion_vote/liste.html.twig', [
    //         'controller_name' => 'GestionVoteController',
    //     ]);
    // }

    /**
     * @Route("/Vote/{idCandidat}", name="app_Vote")
     */
    public function Vote(CandidatsRepository $candidat, int $idCandidat = null, Request $request, EntityManagerInterface $entityManager): Response
    {

        $candidatChoisi = $candidat->findOneBy(["id" => $idCandidat]);

        // dd($candidatChoisi);
        //Ici on recupere la personne qui est connecter
        $personne = $this->getUser();

        $vote = new Vote();
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);
        //d($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $vote = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vote);
            $entityManager->flush();

            return $this->redirectToRoute('app_comptablity');
        }

        return $this->render('gestion_vote/vote.html.twig', [
            'registrationForm' => $form->createView(),
            'controller_name' => 'GestionVoteController',
            'personne' => $personne,
            'candidatChoisi' => $candidatChoisi
        ]);
    }
}
