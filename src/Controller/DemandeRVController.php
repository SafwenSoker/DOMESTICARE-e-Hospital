<?php

namespace App\Controller;

use App\Entity\ComptePatient;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\DemandeRV;
use App\Form\DemandeRVType;
use App\Repository\ComptePatientRepository;
use App\Repository\MedecinRepository;
use App\Repository\PatientRepository;
use App\Repository\DemandeRVRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * @Route("/demande/r/v")
 */
class DemandeRVController extends AbstractController
{
    private $security;
    private $demandeRVRepository;
    public function __construct(Security $security, DemandeRVRepository $demandeRVRepository)
    {
        $this->demandeRVRepository = $demandeRVRepository;
        $this->security = $security;
    }

    /**
     * @Route("/", name="demande_r_v_index", methods={"GET"})
     */
    public function index(DemandeRVRepository $demandeRVRepository): Response
    {
        return $this->render('demande_rv/index.html.twig', [
            'demande_r_vs' => $demandeRVRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{medecin}/{patient}", name="nouveau_demande", methods={"GET","POST"})
     */
    public function new(Medecin $medecin, Patient $patient): Response
    {
        $demandeRV = new DemandeRV();
        $demandeRV->setMedecin($medecin);
        $demandeRV->setPatient($patient);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($demandeRV);
        $entityManager->flush();
        return $this->redirectToRoute('demande_r_v_show');
    }

    /**
     * @Route("/show", name="demande_r_v_show", methods={"GET","POST"})
     */
    public function show(MedecinRepository $medecinRepository, ComptePatientRepository $comptePatientRepository, PatientRepository $patientRepository): Response
    {
        $comptepatient = $comptePatientRepository->findOneBy(['email' => $this->security->getUser()->getUsername()]);
        dump($comptepatient);
        $patient = $patientRepository->findOneBy(['id' => $comptepatient->getPatient()->getId()]);
        $medecinDisponibles = $medecinRepository->findMedecinByRV($patient);
        dump($medecinDisponibles);
        return $this->render('demande_rv/show.html.twig', [
            'medecins' => $medecinDisponibles,
            'comptepatient' => $this->security->getUser()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="demande_r_v_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DemandeRV $demandeRV): Response
    {
        $form = $this->createForm(DemandeRVType::class, $demandeRV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_r_v_index');
        }

        return $this->render('demande_rv/edit.html.twig', [
            'demande_r_v' => $demandeRV,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="demande_r_v_delete", methods={"POST"})
     */
    public function delete(Request $request, DemandeRV $demandeRV): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demandeRV->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demandeRV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('demande_r_v_index');
    }
    /**
     * @Route("/getdr/{id}", name="demande_r_v_get", methods={"GET" , "POST"})
     */
    public function getRV(int $id): Response
    {
        return $this->render("demande_rv/getRV.html.twig", ["demandes" => $this->demandeRVRepository->findRVByPatient($id)]);
    }
}
