<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vote;
use App\Form\VoteType;
use App\Repository\UserRepository;
use App\Repository\CandidatsRepository;
use App\Service\MailerService;
use DateTime;
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
    public function Vote(CandidatsRepository $candidat, int $idCandidat = null, Request $request, EntityManagerInterface $entityManager, MailerService $mailer): Response
    {

        $candidatChoisi = $candidat->findOneBy(["id" => $idCandidat]);

        // dd($candidatChoisi->getId());
        //Ici on recupere la personne qui est connecter
        $personne = $this->getUser();

        return $this->render('gestion_vote/vote.html.twig', [
            // 'registrationForm' => $form->createView(),
            'controller_name' => 'GestionVoteController',
            'personne' => $personne,
            'candidatChoisi' => $candidatChoisi
        ]);
    }



    /**
     * @Route("/aVote/{idCandidat}", name="app_aVote")
     */
    public function aVote(CandidatsRepository $candidat, int $idCandidat = null, EntityManagerInterface $entityManager): Response
    {

        $candidatChoisi = $candidat->findOneBy(["id" => $idCandidat]);
        $personne = $this->getUser();
        // $code = rand(1000, 9000);
        // $to = $this->getUser()->getUserIdentifier();
        // $vote = new Vote();
        // $vote->setIdUser($personne);
        // $vote->setIdCandidat($candidatChoisi);
        // $vote->setDateVote(new DateTime());
        // $entityManager->persist($vote);
        // $entityManager->flush();

        // return $this->redirectToRoute('app_comptablity');

        //debut de mon fonctionalite pour inserer le code de confirmation

        $vote = new Vote();
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($vote);
        //traitemeent et soumission de la depense
        if ($form->isSubmitted() && $form->isValid()) {
            $vote = $form->getData();
            $vote->setIdUser($personne);
            $vote->setIdCandidat($candidatChoisi);
            $vote->setDateVote(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vote);
            $entityManager->flush();

            return $this->redirectToRoute('app_comptablity');
        }
        return $this->render('gestion_vote/vote.html.twig', [
            'form' => $form->createView(),

        ]);
    }


    /**
     * @Route("/email/{idCandidat}", name="app_email")
     */
    public function email(MailerService $mailer, int $idCandidat)
    {
        // $candidatChoisi = $candidat->findOneBy(["id" => $idCandidat]);
        $code = rand(1000, 9000);
        $user = $this->getUser()->getUserIdentifier();
        $mailer->sendEmail($code, $user);
        return $this->redirectToRoute('app_Vote', ['idCandidat' => $idCandidat]);
    }
}
