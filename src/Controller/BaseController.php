<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        $reservations = $user->getReservations();


        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
            'reservations' => $reservations
        ]);
    }
}
