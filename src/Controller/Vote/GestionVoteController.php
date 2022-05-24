<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\CandidatsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/Vote/id", name="app_Vote")
     */
    public function Vote(CandidatsRepository $candidat, int $idCandidat = null): Response
    {

        $candidatChoisi = $candidat->findOneBy(["id" => $idCandidat]);

        //Ici on recupere la personne qui est connecter
        $personne = $this->getUser();

        // dd($personne);


        return $this->render('gestion_vote/vote.html.twig', [
            'controller_name' => 'GestionVoteController',
            'personne' => $personne,
            'candidatChoisi' => $candidatChoisi
        ]);
    }
}
