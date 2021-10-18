<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use App\Repository\ComptePatientRepository;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index(): Response
    {
        return $this->render('message/index.html.twig', []);
    }

    /**
     * @Route("/send", name="send")
     *
     * @return void
     */
    public function send(Request $request, ComptePatientRepository $comptePatientRepository, PatientRepository $patientRepository): Response
    {
        $message = new Messages();
        $comptepatient = $comptePatientRepository->findOneBy(['email' => $this->getUser()->getUsername()]);
        $patient = $patientRepository->find($comptepatient->getId());
        $form = $this->createForm(MessagesType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($patient);
            $message->setIsRead(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash('message', 'Message Envoyé avec succès');

            return $this->redirectToRoute('message');
        }

        return $this->render('message/send.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/recieved", name="recieved")
     *
     * @return void
     */
    public function recieved(): Response
    {
        return $this->render('message/recieved.html.twig');
    }

    /**
     * @Route("/sent", name="sent")
     *
     * @return void
     */
    public function sent(): Response
    {
        return $this->render('message/sent.html.twig');
    }

    /**
     * @Route("/read/{id}", name="read")
     *
     * @return void
     */
    public function read(Messages $message): Response
    {
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('message/read.html.twig', ['message' => $message]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     *
     * @return void
     */
    public function delete(Messages $message): Response
    {
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('recieved');
    }
}
