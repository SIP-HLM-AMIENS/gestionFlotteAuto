<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(Request $req)
    {
        $reservation = new Reservation();
        $reservation->setPersonne($this->getUser());
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            return $this->render('reservation/reservation.html.twig', [
                'form' => $form->createView(),
                'charger' => true,
            ]);
        }

        return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView(),
            'charger' => false,
        ]);
    }
}
