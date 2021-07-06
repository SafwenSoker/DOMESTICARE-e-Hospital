<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\DemandeRVRepository;
use App\Repository\MedecinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medecin")
 */
class MedecinController extends AbstractController
{


    /**
     * @Route("/", name="medecin_index", methods={"GET"})
     */
    public function index(MedecinRepository $medecinRepository): Response
    {
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
    }
    /**
     * @Route("/{id}", name="medecin_show", methods={"GET"})
     */
    public function show(Medecin $medecin): Response
    {
        return $this->render('medecin/show.html.twig', [
            'medecin' => $medecin,
        ]);
    }
    /**
     * @Route("/demande/{id}", name="demande_rv_medecin", methods={"GET","POST"})
     */
    public function DemandeRV(Medecin $medecin, DemandeRVRepository $demandeRVRepository): Response
    {
        $demandesRVs = $demandeRVRepository->findBy(['medecin' => $medecin->getId()]);
        return $this->render("medecin/demanderv.html.twig", ["demandes" => $demandesRVs]);
    }
}
