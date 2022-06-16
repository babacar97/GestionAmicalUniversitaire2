<?php

namespace App\Controller\ProfileUtilisateurs;

use App\Repository\CalendarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileUtilisateursController extends AbstractController
{
    /**
     * @Route("/profile/utilisateurs", name="app_profile_utilisateurs")
     */
    public function index(): Response
    {
        return $this->render('profile_utilisateurs/index.html.twig', [
            'controller_name' => 'ProfileUtilisateursController',
        ]);
    }

    /**
     * @Route("/actu", name="app_actu")
     */
    public function actu(): Response
    {
        return $this->render('profile_utilisateurs/actu.html.twig');
    }

    /**
     * @Route("/utievent", name="app_utievent", methods={"GET"})
     */
    public function lsevents(CalendarRepository $calendarRepository): Response
    {
        return $this->render('profile_utilisateurs/events.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }
}
