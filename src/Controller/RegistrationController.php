<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/enregistrement", name="enregistrement")
     */
    public function enregistrement(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {   
        $user = new Utilisateurs();
        $form = $this->createForm(UtilisateursType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            if($form->get('role')->getData())
            {
                $roles[] = 'ROLE_ADMIN';
            }
            else
            {
                $roles[] = 'ROLE_USER';
            }
            $user->setRoles($roles);
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/enregistrement.html.twig', 
            array('form' => $form->createView())
        );
    }
}
