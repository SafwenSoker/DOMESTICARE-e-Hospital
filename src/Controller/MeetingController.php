<?php

namespace App\Controller;

use DateTime;
use DateTimeInterface;
use App\Entity\Medecin;
use App\Entity\Meeting;
use App\Entity\Patient;
use App\Service\MeetingGenerator;
use App\Repository\MedecinRepository;
use App\Repository\MeetingRepository;
use App\Repository\PatientRepository;
use App\Repository\CompteMedecinRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeetingController extends AbstractController
{
    private $meetingRepository;
    private $patientRepository;
    public function __construct(MeetingRepository $meetingRepository, PatientRepository $patientRepository)
    {
        $this->meetingRepository = $meetingRepository;
        $this->patientRepository = $patientRepository;
    }
    /**
     * @Route("/meeting/{patient}/{medecin}", name="generate_meeting")
     */
    public function index(Patient $patient, Medecin $medecin, MeetingGenerator $meetingGenerator): Response
    {
        $meeting = new Meeting();
        if ($patient != null && $medecin != null) {
            dump($meeting_data = array($meetingGenerator->generateMeeting()));
            $data = array($meeting_data[0]);
            $meeting->setMedecin($medecin);
            $meeting->setTopic($data[0]->topic);
            $meeting->setPatient($patient);
            $meeting->setUuid($data[0]->uuid);
            $meeting->setSndId($data[0]->id);
            $meeting->setHostEmail($data[0]->host_email);
            $meeting->setHostId($data[0]->host_id);
            $meeting->setStartTime(new \DateTime($data[0]->start_time));
            $meeting->setDuration($data[0]->duration);
            $meeting->setCreatedAt(new \DateTime($data[0]->created_at));
            $meeting->setStartUrl($data[0]->start_url);
            $meeting->setJoinUrl($data[0]->join_url);
            $meeting->setPassword($data[0]->password);
            $meeting->setH323Password($data[0]->h323_password);
            $meeting->setPstnPassword($data[0]->pstn_password);
            $meeting->setEncryptedPassword($data[0]->encrypted_password);
            $meeting->setStatus($data[0]->status);

            $em = $this->getDoctrine()->getManager();
            $em->persist($meeting);
            $em->flush();
            return $this->redirectToRoute("demande_rv_medecin", ["id" => $medecin->getId()]);
        }
        return $this->redirectToRoute("demande_rv_medecin", ["id" => $medecin->getId()]);
    }

    /**
     * @Route("/consultations/{id}", name="consultations", requirements={"id":"\d+"})
     */
    public function showConsultations(Patient $patient)
    {
        $patient = $this->patientRepository->find($patient->getId());
        return $this->render(
            "demande_rv/consultations_patient.html.twig",
            [
                "consultations" => $this->meetingRepository->findBy(['patient' => $patient->getId()])
            ]
        );
    }

    /**
     * @Route("/meetings/{id}", name="meetings", requirements={"id":"\d+"})
     */
    public function showMeetings(Medecin $medecin)
    {
        return $this->render(
            "demande_rv/consultations_medecin.html.twig",
            [
                "consultations" => $this->meetingRepository->findBy(['medecin' => $medecin->getId()])
            ]
        );
    }
}
