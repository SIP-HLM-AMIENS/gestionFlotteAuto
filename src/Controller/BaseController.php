<?php

namespace App\Controller;

use App\Entity\Pointage;
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
        return $this->render('base/accueil.html.twig', [
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
        $repoPointage = $this->getDoctrine()->getRepository(Pointage::class);
        $reservations = $repository->findFutureReservationByUser($user->getId());
        $pointages = $repoPointage->findBy(['reservation'=> null, 'utilisateur'=>$user->getId()]);
        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
            'reservations' => $reservations,
            'pointages' => $pointages
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
            $e['title'] = 'Voiture N°'.$reservation->getVoiture().' '.$reservation->getPersonne()->getUsername();
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


    /**
     * @Route("/chargementCalendrier2", name="chargementCalendrier2")
     */
    public function chargementCalendrier2()
    {
        $user = $this->getUser();
        $service = $user->getService();
        foreach($service->getUtilisateurs() as $personne)
        {
            $reservations = $personne->getReservations();

            $calendrier = array();
            foreach($reservations as $reservation){
                $e = array();
                $e['id'] = $reservation->getId();
                $e['title'] = $reservation->getPersonne()->getUsername();
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
        }
        

        return new JsonResponse($calendrier);
        /********************************* */
    }
}
