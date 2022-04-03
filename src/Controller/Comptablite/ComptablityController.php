<?php

namespace App\Controller\Comptablite;

use App\Entity\Budget;
use App\Form\BudgetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $depense = new Budget();
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
            'registrationForm' => $form->createView(),

        ]);
    }
}
