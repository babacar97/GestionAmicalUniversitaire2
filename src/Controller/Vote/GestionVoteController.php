<?php

namespace App\Controller;

use App\Repository\CandidatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionVoteController extends AbstractController
{
    /**
     * @Route("/listeCandidats", name="app_listecandidat")
     */
    public function index(CandidatsRepository $candidats)
    {
        $listeCandidats = $candidats->findAll();
        // dd($listeCandidats);
        return $this->render('gestion_vote/listeCandidats.html.twig', [
            'controller_name' => 'GestionVoteController',
            'listeCandidats' => $listeCandidats
        ]);
    }

    // /**
    //  * @Route("/listeCandidats", name="app_listecandidat")
    //  */
    // public function candidat()
    // {
    //     return $this->render('');
    // }
}
