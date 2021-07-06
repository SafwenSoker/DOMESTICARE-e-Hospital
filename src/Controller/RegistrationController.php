<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\ComptePatient;
use App\Form\RegistrationFormType;
use App\Security\ComptePatientAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RegistrationController extends AbstractController
{
    private $tokenStorage;
    private $eventDispatcher;
    /**
     * @Route("/compte/patient/inscription", name="compte_patient_inscription")
     */
    public function register(TokenStorageInterface $token, Request $request, UserPasswordEncoderInterface $passwordEncoder, ComptePatientAuthenticator $login, GuardAuthenticatorHandler $guard): Response
    {
        $this->tokenStorage = new TokenStorage();
        $this->eventDispatcher = new EventDispatcher();
        $patient = new Patient();
        $user = new ComptePatient();
        $user->setPatient($patient);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $token = new UsernamePasswordToken($user, $login->getCredentials($request), 'patient_firewall', $user->getRoles());
            $this->tokenStorage->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->eventDispatcher->dispatch($event, SecurityEvents::INTERACTIVE_LOGIN);
            return $this->render('patient/index.html.twig', ["comptepatient" => $user]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
