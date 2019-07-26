<?php

namespace App\Service;

use DateTime;
use App\Entity\Voiture;
use App\Entity\Utilisateurs;

class ReservationService
{
    public function GetVoituresDispoService(Utilisateurs $user, DateTime $debutP, DateTime $finP, int $place)
    {
        if($user != null)
        {
            $service = $user->getService();
        
            if($service != null)
            {
                $voitures = $service->getVoitures();
                $voituresDispoService = null;
                foreach($voitures as $voiture)
                {
                    $Dispo = true;
                    //vérification etat de la voiture
                    if($voiture->getEtat() == true)
                    {   //Récupération des reservations de la voiture
                        foreach($voiture->getReservations() as $reservation)
                        {
                            $début = $reservation->getDebut();
                            $fin = $reservation->getFin();

                            //vérification de la disponibiltée de la voiture pour la période donnée
                            if(($debutP < $fin)&&($finP > $début))
                            {
                                $Dispo=false;
                            }
                        } 
                    }
                    else
                    {
                        $Dispo = false;
                    }
                    if($Dispo)
                    {
                        $voituresDispoService[] = $voiture;
                    }
                }
            }
        }
        return $voituresDispoService;

    }

    public function GetVoituresDispo(Array $voitures, DateTime $debutP, DateTime $finP, int $place)
    {
        $voituresDispo = null;
        foreach($voitures as $voiture)
        {   if($voiture->getEtat() == true) // Filtre sur les voiture à l'etat dispo
            {
                if($this->IsVoitureDispo($voiture, $debutP, $finP))
                {
                    $voituresDispo[] = $voiture;
                }
            }
        }
        return $voituresDispo;
    }

    private function IsVoitureDispo(Voiture $voiture, DateTime $debutP, DateTime $finP)
    {
        $Dispo = true;
        //Récupération des reservations de la voiture
        foreach($voiture->getReservations() as $reservation)
        {
            $début = $reservation->getDebut();
            $fin = $reservation->getFin();

            //vérification de la disponibiltée de la voiture pour la période donnée
            if(($debutP < $fin)&&($finP > $début))
            {
                $Dispo=false;
            }
        }
        return $Dispo;

    }
}
