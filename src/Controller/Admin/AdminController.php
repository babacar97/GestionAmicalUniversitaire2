<?php

namespace App\Controller\Admin;

use  App\Entity\User;
use  App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/home.html.twig');
    }

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
            // $user->setEmail($userData->getEmail());
            $user->setNumeroCarteIdentite($user->getNumeroCarteIdentite());
            // $user->setImage($userData->getImage());
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('listeUtilisateur');
        }
        return $this->render(
            'admin/user/edit.html.twig',
            [
                'registrationForm' => $form->createView(),
                'user' => $user,
            ]
        );
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
