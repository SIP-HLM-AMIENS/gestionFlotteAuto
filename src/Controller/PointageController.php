<?php

namespace App\Controller;

use App\Entity\Pointage;
use App\Form\PointageType;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PointageController extends AbstractController
{
    /**
     * @Route("/pointage", name="pointage")
     */
    public function index(Request $req, ObjectManager $manager)
    {
        $pointage = new Pointage();

        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $repository->findBy(
            [
             'personne'=> $user->getId(),
             'etat' => false
            ]
        );

        $form = $this->createForm(PointageType::class, $pointage, array('reservations' => $reservations));
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->addFlash('Ok','Action validée');
            $manager->persist($pointage);

            $reservation = $pointage->getReservation();
            $reservation->setEtat(true);
            $manager->persist($reservation);

            $manager->flush();
            
            return $this->redirectToRoute('tableauDeBord');
        }


        return $this->render('pointage/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
