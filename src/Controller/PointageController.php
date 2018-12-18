<?php

namespace App\Controller;

use App\Entity\Pointage;
use App\Form\PointageType;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            //persistance du pointage
            $manager->persist($pointage);

            //association reservation -> pointage
            $reservation = $pointage->getReservation();
            $reservation->setEtat(true);

            //Mise a jour emplacement véhicule
            $reservation->getVoiture()->setEmplacement($pointage->getEmplacement());

            //Mise à jour kilometrage véhicule
            $reservation->getVoiture()->setKilometrage($pointage->getKiloApres());

            $manager->persist($reservation);

            $manager->flush();
            
            return $this->redirectToRoute('tableauDeBord');
        }


        return $this->render('pointage/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/association", name="association")
     */
    public function association(Request $req, ObjectManager $manager)
    {
        $form = $this->createFormBuilder()
        ->add('save', SubmitType::class, array(
                'label' => 'Associer !',
                'attr' => array('class'=>'btn btn-primary')
                )
            )
        ->getForm();
        
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            if(isset($_POST['pointageCheck'])&& isset($_POST['reservationCheck']))
            {
                $emReservation = $this->getDoctrine()->getRepository(Reservation::class);
                $reservation = $emReservation->find($_POST['reservationCheck']);
                $emPointage = $this->getDoctrine()->getRepository(Pointage::class);
                $pointage = $emPointage->find($_POST['pointageCheck']);

                $reservation->setPointage($pointage);
                $reservation->setEtat(true);
                $manager->persist($reservation);
                $manager->flush();
            }
        }

        $user = $this->getUser();
        $repoReservation = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $repoReservation->findBy(
            [
            'personne'=> $user->getId(),
            'etat' => false
            ]
        );

        $repoPointage = $this->getDoctrine()->getRepository(Pointage::class);
        $pointages = $repoPointage->findBy(
            [
                'reservation'=> null,
                'utilisateur'=>$user->getId()
            ]
        );

        return $this->render('pointage/association.html.twig', [
            'reservations' => $reservations,
            'pointages' => $pointages,
            'form' => $form->createView()
        ]);

    }
}
