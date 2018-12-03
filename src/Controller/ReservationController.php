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
    public function index(Request $req, ReservationService $RS, ObjectManager $manager)
    {
        $reservation = new Reservation();
        $reservation->setPersonne($this->getUser());
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getRepository(Voiture::class);
            if($form->get('load')->isClicked())
            {   
                //charger les voitures du service disponible
                $voitures = $RS->GetVoituresDispoService($this->getUser(), $reservation->getDebut(), $reservation->getFin());
                $service = 'interne';
                if($voitures == null)
                {
                    $service ='externe';
                    $voituresTemp = $em->findOutsideService($this->getUser()->getService()->getId());
                    $voitures = $RS->GetVoituresDispo($voituresTemp, $reservation->getDebut(), $reservation->getFin());
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

                /*if($arret->getVisiteReprise() == 1)
                {
                    $this->EnvoyerMail($mailer);
                }*/

                return $this->redirectToRoute('tableauDeBord');
            }


        }

        return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView(),
            'charger' => false,
        ]);
    }
}
