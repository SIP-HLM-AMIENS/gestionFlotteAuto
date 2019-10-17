<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Service\ReservationService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(Request $req, ReservationService $RS, ObjectManager $manager, \Swift_Mailer $mailer)
    {
        $reservation = new Reservation();
        $reservation->setPersonne($this->getUser());
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->get("security.csrf.token_manager")->refreshToken("form_intention");
            $em = $this->getDoctrine()->getRepository(Voiture::class);
            if($form->get('load')->isClicked())
            {   
                //Vérification des horaires renseignés
                if($reservation->getDebut() >= $reservation->getFin())
                {
                    return $this->render('reservation/reservation.html.twig', [
                        'form' => $form->createView(),
                        'charger' => false,
                    ]);
                }

                //charger les voitures du service disponible
                $voitures = $RS->GetVoituresDispoService($this->getUser(), $reservation->getDebut(), $reservation->getFin(),$reservation->getOptplace());
                $service = 'interne';
                if($voitures == null)
                {
                    $service ='externe';
                    $voituresTemp = $em->findOutsideService($this->getUser()->getService()->getId());
                    $voitures = $RS->GetVoituresDispo($voituresTemp, $reservation->getDebut(), $reservation->getFin(), $reservation->getOptPlace());
                }

                return $this->render('reservation/reservation.html.twig', [
                    'form' => $form->createView(),
                    'charger' => true,
                    'localité' => $service,
                    'voitures' => $voitures
                ]);
            }
            elseif($form->get('save')->isClicked())
            {
                $this->addFlash('Ok','Action validée');
                $data = $form->getData();
                $reservation->setVoiture($em->find($_POST['voitureChoisie']));
                $reservation->setPersonne($this->getUser());
                $reservation->setEtat(false);
                $manager->persist($reservation);
                $manager->flush();

                $this->EnvoyerMail($mailer, $reservation);
                return $this->render('reservation/recapitulatif.html.twig', [
                    'reservation' => $reservation
                ]);
            }
        }

        return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView(),
            'charger' => false,
        ]);
    }

    public function EnvoyerMail(\Swift_Mailer $mailer, $reservation)
    {
        $message = (new \Swift_Message('Reservation de véhicule'))
        ->setFrom('flotte.auto@sip-picardie.com')
        ->setTo(
            [
                $reservation->getPersonne()->getEmail(),
                $reservation->getVoiture()->getResponsable()->getEmail()
            ])
        ->setBcc('leconte.kevin@sip-picardie.com')
        ->setBody(
            $this->renderView(
                'emails/reservation.html.twig', 
                [
                    'reservation' => $reservation
                ]
            ),
            'text/html'
        );
        $mailer->send($message);
    }

}
