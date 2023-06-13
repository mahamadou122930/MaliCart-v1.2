<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'account')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('oldpassword')->getData();
            dd($old_pwd);
            if($userPasswordHasher->isPasswordValid($user, $old_pwd)) {

            }
        }

        return $this->render('account/index.html.twig', [
            'account'=> $form->createView()
        ]);
    }

}
