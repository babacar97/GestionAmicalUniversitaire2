<?php

namespace App\Controller\ProfileUtilisateurs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
