<?php

namespace App\Controller\Comptablite;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComptablityController extends AbstractController
{
    /**
     * @Route("/comptablity", name="app_comptablity")
     */
    public function index(): Response
    {
        return $this->render('comptablity/index.html.twig', [
            'controller_name' => 'ComptablityController',
        ]);
    }

    /**
     * @Route("/newbudget", name="app_newbudget")
     */
    public function newbudget(): Response
    {
        return $this->render('comptablity/newbudget.html.twig');
    }
}
