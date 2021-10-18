<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ComptePatientSecurityController extends AbstractController
{
    /**
     * @Route("/compte/patient/connecter", name="compte_patient_connecter")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('compte_patient_security/connecter.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/compte/patient/deconnecter", name="compte_patient_deconnecter")
     */
    public function logout()
    {
    }
}
