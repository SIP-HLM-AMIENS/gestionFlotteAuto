<?php

namespace App\Controller;

use App\Entity\Reservation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function index()
    {
        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }

    /**
     * @Route("/base", name="tableauDeBord")
     */
    public function tableauDeBord()
    {
        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $repository->findFutureReservationByUser($user->getId());
        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
            'reservations' => $reservations
        ]);
    }

    /**
     * @Route("/chargementCalendrier", name="chargementCalendrier")
     */
    public function chargementCalendrier()
    {
        $user = $this->getUser();
        $reservations = $user->getReservations();

        $calendrier = array();
        foreach($reservations as $reservation){
            $e = array();
            $e['id'] = $reservation->getId();
            $e['title'] = 'Voiture N°'.$reservation->getVoiture().' ';
            $e['start'] = $reservation->getDebut()->format('Y-m-d H:i');
            $e['end'] = $reservation->getFin()->format('Y-m-d H:i');
            if($reservation->getEtat())
            {
               $e['color'] = 'green';
            }
            else
            {
                if($reservation->getDebut() > new \Datetime('NOW'))
                {
                    $e['color'] = 'yellow';
                }
                else
                    $e['color'] = 'red';
            }
            $e['allDay'] = false;
            array_push($calendrier, $e);
        }
        

        return new JsonResponse($calendrier);
        /********************************* */
    }
}
