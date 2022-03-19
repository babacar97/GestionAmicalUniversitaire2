<?php

namespace App\Controller\Admin;

use  App\Entity\User;
use App\Repository\UserRepository;
use  App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    public function edit(UserRepository $Repository, int $id, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $user = $Repository->findOneBy(["id" => $id]);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getdata();

            $photo = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('personne_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImage($newFilename);
            }
            // $user->setEmail($userData->getEmail());
            // $user->setNumeroCarteIdentite($user->getNumeroCarteIdentite());
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
