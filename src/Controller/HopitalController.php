<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Repository\HopitalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HopitalController extends AbstractController
{
    /**
     * @Route("/", name="hopital_index", methods={"GET"})
     */
    public function index(HopitalRepository $hopitalRepository): Response
    {
        return $this->render('hopital/index.html.twig', [
            'hopital' => $hopitalRepository->find(1001),
        ]);
    }

    /**
     * @Route("/hopital/footer", name="hopital_footer", methods={"GET", "POST"})
     */
    public function footer(HopitalRepository $hopitalRepository): Response
    {
        return $this->render('shared/footer.html.twig', [
            'hopital' => $hopitalRepository->find(1001),
        ]);
    }
}
