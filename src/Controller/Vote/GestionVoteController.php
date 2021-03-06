<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Vote;
use App\Form\VoteType;
use App\Repository\CampagneRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\CandidatsRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $code = rand(1000, 9000);
        $to = $this->getUser()->getUserIdentifier();
        $vote = new Vote();
        $vote->setIdUser($personne);
        $vote->setIdCandidat($candidatChoisi);
        $vote->setDateVote(new DateTime());
        $entityManager->persist($vote);
        $entityManager->flush();

        return $this->redirectToRoute('app_comptablity');
    }


    /**
     * @Route("/email/{idCandidat}", name="app_email")
     */
    public function email(MailerService $mailer, int $idCandidat, EntityManagerInterface $entityManager, CandidatsRepository $candidat)
    {
        $candidatChoisi = $candidat->findOneBy(["id" => $idCandidat]);
        $vote = new Vote();
        $code = rand(1000, 9000);
        $user = $this->getUser()->getUserIdentifier();
        $userCon = $this->getUser();
        $mailer->sendEmail($code, $user);
        $vote->setCodeDeConfirmation($code);
        $vote->setIdUser($userCon);
        $vote->setDateVote(new \DateTime());
        $vote->setIdCandidat($candidatChoisi);
        $vote->setAVoter(false);

        $entityManager->persist($vote);
        $entityManager->flush();
        return $this->redirectToRoute('app_Vote', ['idCandidat' => $idCandidat]);
    }

    /**
     * @Route("/validation/{idCandidat}", name="app_validation")
     */
    public function validationVote(VoteRepository $voteRepo, Request $request, int $idCandidat, EntityManagerInterface $entityManager, CandidatsRepository $candidatsRepository)
    {
        $user = $this->getUser();
        $code = $request->query->get('code');
        $vote = $voteRepo->findOneBy(['codeDeConfirmation' => $code, 'id_user' => $user]);



        if ($vote) {

            $vote->setAVoter('true');
            $vote->setDateVote(new \DateTime());
            $entityManager->persist($vote);
            $entityManager->flush($vote);
        }
        return $this->redirectToRoute('app_Vote', ['idCandidat' => $idCandidat]);
    }


    /**
     * @Route("/resultvote", name="app_resulte")
     */
    public function ResulteVote(CampagneRepository $campagne, CandidatsRepository $candidats)
    {
        $listeCampagnes = $campagne->findAll();
        $listeCandidats = $candidats->findAll();

        return $this->render('gestion_vote/resulteVote.html.twig', [
            'listeCampagnes' => $listeCampagnes,
            'listeCandidats' => $listeCandidats,
        ]);
    }
}
