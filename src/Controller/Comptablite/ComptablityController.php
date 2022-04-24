<?php

namespace App\Controller\Comptablite;

use App\Entity\Budget;
use App\Entity\Depense;
use App\Form\BudgetType;
use App\Form\DepenseType;
use App\Repository\BudgetRepository;
use App\Repository\DepenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function PHPSTORM_META\type;

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
    public function idbudget($idBudget, BudgetRepository $budgetRepository, DepenseRepository $depenseRepository)
    {
        $idbudget = $budgetRepository->findOneById($idBudget);
        $budget = $budgetRepository->findAll();
        $iddepenses = $depenseRepository->findBy(['budget' => $idbudget]);
        //dd($iddepenses);
        // dd($dt->getDepense());
        // $montantdepense = $iddepenses->getMontant();
        // $typedepense = $iddepenses->getType();
        // dd(sizeof($iddepenses));
        // dd($typedepense);
        // $idbd = $depenseRepository->findAll();
        // dd($idbd);


        //totale des dépenses effectuer
        $sumDepense = 0;
        foreach ($iddepenses as $sum) {
            $sumDepense += $sum->getMontant();
        }
        // dd($sumDepense);
        $date = $idbudget->getDate();
        // dd($date);

        $budgetdepense = $idbudget->getDepense();
        // dd($budgetdepense);
        $nombudget =  $idbudget->getnombudget();
        $montantBudget = $idbudget->getmontant();

        $budgetmoinsdepense = $idbudget->getBudgetmoinsdepense();
        // dd($budgetmoinsdepense);
        return $this->render('comptablity/infoBudget.html.twig', [
            'idbudgetBudgets' => $idbudget,
            'id' => $idbudget->getId(),
            'montantBudget' => $montantBudget,
            'budgetdepense' => $budgetdepense,
            'budgetmoinsdepense' => $budgetmoinsdepense,
            'listeBudgets' => $budget,
            'nombudget' => $nombudget,
            'datebudget' => $date,
            'iddepenses' => $iddepenses
            // 'types' => $types,
            // 'montants' => $montants
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

    // /**
    //  * @Route("/newDepense/{id}", name="newDepense")
    //  */
    // public function redirectRoute($id, BudgetRepository $budgetRepository)
    // {
    //     $budget = $budgetRepository->findOneBy(["id" => $id]);

    //     $budgetid = $budget->getId();
    //     // dd($budgetid);
    //     return $this->redirectToRoute('app_newDepense', [
    //         'budgetid' => $budgetid,
    //     ]);
    // }

    /**
     * @Route("/newDepense/{id}", name="app_newDepense")
     */
    public function newDepense($id, Request $request, EntityManagerInterface $entityManager, BudgetRepository $budgetRepository)
    {


        $budget = $budgetRepository->findOneBy(["id" => $id]);
        // dd($budget);
        $budgetid = $budget->getId();
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
            'budgetid' => $budgetid
        ]);
    }
}
