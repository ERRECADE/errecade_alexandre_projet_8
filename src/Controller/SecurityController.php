<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SecurityController extends AbstractController
{

    #[Route('/login', name: 'login')]
    public function loginAction(Request $request,AuthenticationUtils $authenticationUtils,UserRepository $UserRepository)
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/login_check', name: 'login_check')]
    /**
     * @codeCoverageIgnore
     */
    public function loginCheck() :void
    {
        // This code is never executed.
    }

    #[Route('/logout', name: 'logout')]
    /**
     * @codeCoverageIgnore
     */
    public function logoutCheck() :void
    {
        // This code is never executed.
    }
}
