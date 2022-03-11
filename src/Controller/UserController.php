<?php

namespace App\Controller;

use  App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="listeUtilisateur")
     */
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }


    /**
     * @Route("/edit/{id}", name="userEdit")
     */
    public function edit(UserRepository $Repository, int $id, Request $request, EntityManagerInterface $manager): Response
    {
        $user = $Repository->findOneBy(["id" => $id]);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getdata();

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('listeUtilisateur');
        }
        return $this->render('admin/user/edit.html.twig', ['registrationForm' => $form->createView()]);
    }


    /**
     * @Route("/delete/{id}", name="userDelete")
     */

    public function supprime(EntityManagerInterface $manager, User $user): Response
    {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('listeUtilisateur');
    }
}
