<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function listAction(UserRepository $userRepository)
    {
        return $this->render('user/list.html.twig', ['users' => $userRepository->findAll()]);
    }

    #[Route('/users/create', name: 'user_create')]
    public function createAction(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $user = new User();
        $form = $this->createForm(\App\Form\UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())  {
            $password = $userPasswordHasherInterface->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            // if($user->getRoles() == 'ROLE_USER'){
            //     $user->setRoles($user->getRoles()); 
            // }
            // $user->setRoles($user->getRoles());
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }
        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    // #[IsGranted('edit')]
    public function editAction(User $user, Request $request,EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()){
            $password = $userPasswordHasherInterface->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            // $user->setRoles($user->getRoles());

            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }
        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
