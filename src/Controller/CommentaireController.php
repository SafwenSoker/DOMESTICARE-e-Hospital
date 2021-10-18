<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Maladie;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\ComptePatientRepository;
use App\Repository\MaladieRepository;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/new/{id}", name="commentaire_new", methods={"GET","POST"})
     */
    public function new(Maladie $maladie, Request $request, ComptePatientRepository $comptepatientRepository, PatientRepository $patientRepository, MaladieRepository $maladieRepository): Response
    {
        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $comptepatient = $comptepatientRepository->findOneBy(['email' => $this->security->getUser()->getUsername()]);
        $patient = $patientRepository->find($comptepatient->getPatient()->getId());
        $commentaire->setPatient($patient);
        $maladie = $maladieRepository->find($maladie->getId());
        $commentaire->setMaladie($maladie);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($request);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->render('maladie/show.html.twig', ['maladie' => $maladie]);
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form'        => $form->createView(),
            'id'          => $maladie->getId(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_show", methods={"GET","POST"})
     */
    public function show(Maladie $maladie, CommentaireRepository $commentaireRepository): Response
    {
        $commentaires = $commentaireRepository->findBy(['maladie' => $maladie->getId()]);

        return $this->render('commentaire/show.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commentaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentaire $commentaire): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentaire_index');
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Commentaire $commentaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commentaire_index');
    }

    /**
     * @Route("/{id}/vote/{direction}" , methods={"POST"})
     */
    public function commentVote($id, $direction)
    {
        if ($direction === 'up') {
            $currentVoteCount = rand(7, 100);
        } else {
            $currentVoteCount = rand(0, 5);
        }

        return $this->json(['votes' => $currentVoteCount]);
    }
}
