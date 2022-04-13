<?php

namespace App\Controller\Comptablite;

use App\Entity\Budget;
use App\Entity\Depense;
use App\Form\BudgetType;
use App\Form\DepenseType;
use App\Repository\BudgetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComptablityController extends AbstractController
{
    /**
     * @Route("/comptablity", name="app_comptablity")
     */
    public function index(BudgetRepository $budgetRepository): Response
    {
        $budget = $budgetRepository->findAll();
        return $this->render('comptablity/index.html.twig', [
            'controller_name' => 'ComptablityController',
            'listeBudgets' => $budget
        ]);
    }

    /**
     * @Route("/idbudget/{idBudget}", name="app_budget")
     */
    public function idbudget($idBudget, BudgetRepository $budgetRepository)
    {

        $idbudget = $budgetRepository->findOneById($idBudget);
        dd($idbudget);

        $budget = $budgetRepository->findAll();



        // $budgetdepense = $idbudget->getdepense();
        // $nombudget =  $idbudget->getnom_budget();

        $montantBudget = $idbudget->getmontant();


        $budgetmoinsdepense = $idbudget->getBudgetmoinsdepense();

        return $this->render('comptablity/infoBudget.html.twig', [
            'idbudgetBudgets' => $idbudget,
            'montantBudget' => $montantBudget,
            // 'budgetdepense' => $budgetdepense,
            'budgetmoinsdepense' => $budgetmoinsdepense,
            'listeBudgets' => $budget,
            // 'nombudget' => $nombudget
        ]);
    }


    /**
     * @Route("/Budget/{slug}", name="Budget_id")
     */
    // public function budgetId(BudgetRepository $budgetRepository, Request $request,  $slug): Response
    // {
    //     // $budget = $budgetRepository->findOneBy(["id" => $id]);
    //     $post = $budgetRepository->findOneBy(['slug' => $slug]);

    //     return $this->render('comptablity/infoBudget.html.twig', [
    //         'post' => $post
    //     ]);
    // }

    /**
     * @Route("/newbudget", name="app_newbudget")
     */
    public function newbudget(Request $request, EntityManagerInterface $entityManager)
    {
        $budget = new Budget();
        $form = $this->createForm(BudgetType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $budget = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($budget);
            $entityManager->flush();

            return $this->redirectToRoute('app_comptablity');
        }


        return $this->render('comptablity/newBudget.html.twig', [
            'registrationForm' => $form->createView(),

        ]);
    }

    /**
     * @Route("/newDepense", name="app_newDepense")
     */
    public function newDepense(Request $request, EntityManagerInterface $entityManager)
    {
        $depense = new Depense();
        $form = $this->createForm(DepenseType::class, $depense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $depense = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($depense);
            $entityManager->flush();

            return $this->redirectToRoute('app_comptablity');
        }


        return $this->render('comptablity/newDepense.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
