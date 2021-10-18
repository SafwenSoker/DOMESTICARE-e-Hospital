<?php

namespace App\Controller;

use App\Entity\Token;
use App\Form\TokenType;
use App\Repository\TokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/token")
 */
class TokenController extends AbstractController
{
    /**
     * @Route("/", name="token_index", methods={"GET"})
     */
    public function index(TokenRepository $tokenRepository): Response
    {
        return $this->render('token/index.html.twig', [
            'tokens' => $tokenRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="token_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $token = new Token();
        $form = $this->createForm(TokenType::class, $token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($token);
            $entityManager->flush();

            return $this->redirectToRoute('token_index');
        }

        return $this->render('token/new.html.twig', [
            'token' => $token,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="token_show", methods={"GET"})
     */
    public function show(Token $token): Response
    {
        return $this->render('token/show.html.twig', [
            'token' => $token,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="token_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Token $token): Response
    {
        $form = $this->createForm(TokenType::class, $token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('token_index');
        }

        return $this->render('token/edit.html.twig', [
            'token' => $token,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="token_delete", methods={"POST"})
     */
    public function delete(Request $request, Token $token): Response
    {
        if ($this->isCsrfTokenValid('delete'.$token->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($token);
            $entityManager->flush();
        }

        return $this->redirectToRoute('token_index');
    }
}
