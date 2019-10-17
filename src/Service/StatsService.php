<?php

namespace App\Service;

use App\Entity\Pointage;
use Doctrine\ORM\EntityManagerInterface;

class StatsService
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

        //Affichage du taux d'utilisation de chaque voitures, pour un mois données.
        public function calcul1($voitures,$mois)
        {
            $nombreDeJours = intval(date("t",$mois));
            $debut = mktime(0,0,0,$mois,1,date('Y'));
            $fin = mktime(0,0,0,$mois,$nombreDeJours,date('Y'));
            $nombreDeJoursOuvrés = $this->nb_jours(date('d-m-Y',$debut),date('d-m-Y',$fin));

            //calcul le taux d'utilisation des véhicules pour un mois donné


            $arrayToDataTable[] = ['Année 2019', '% utilisation', ['role' => 'tooltip']];

            foreach($voitures as $voiture)
            {

                //Initialisation du tableau de récupération des dates de pointages
                for($i=1;$i<=$nombreDeJours;$i++)
                {
                    $tab[$i][1] = false;
                    $tab[$i][2] = false;
                }

                $PR = $this->em->getRepository(Pointage::class);
                //récupérations des pointages du mois pour le véhicule courant
                $pointages = $PR->findByMois($voiture,$mois,$nombreDeJours);
                //Pour chaque pointage, nous récupérons le jour, et la demi journée du pointage
                foreach($pointages as $pointage)
                {
                    $j = intval($pointage->getSortie()->format('d'));
                    if($pointage->getSortie()->format('H')>13)
                    {
                        $d = 2;
                    }
                    else
                    {
                        $d = 1;
                    }
                    $tab[$j][$d] = true;
                }


                //Parcours du tableau d'initialisation afin de compter le nombre de demi journée la voiture a été utilisée
                $count=0;
                for($i=1;$i<=$nombreDeJours;$i++)
                {
                    if($tab[$i][1] == true)
                        $count++;
                    
                    if($tab[$i][2] == true)
                        $count++;
                }

                //calcul du pourcentage d'utilisation en fonction du nombre de jour ouvrés
                $val = round(($count / $nombreDeJoursOuvrés), 4);
                $tooltip = $val * 100;

                $arrayToDataTable[] = [$voiture->getNumero(), $val, "$tooltip %"];
            
            }

            return $arrayToDataTable;
        }

        //Affichage de l'évolution des réservations sur l'année
        public function calcul2($reservations)
        {
            //il faut un tableau de mois
            $tabMois['01'] = 0;
            $tabMois['02'] = 0;
            $tabMois['03'] = 0;
            $tabMois['04'] = 0;
            $tabMois['05'] = 0;
            $tabMois['06'] = 0;
            $tabMois['07'] = 0;
            $tabMois['08'] = 0;
            $tabMois['09'] = 0;
            $tabMois['10'] = 0;
            $tabMois['11'] = 0;
            $tabMois['12'] = 0;


            //pour chaque reservation, il nous faut ajouter la reservation dans le mois correspondant
            foreach($reservations as $reservation)
            {
                $dateSortie = $reservation->getDebut();
                $mois = $dateSortie->format('m');
                $tabMois[$mois] = $tabMois[$mois] + 1;
            }

            //Nous créons le tableau de résultat avec les valeurs récupérés pour chaque mois.
            $tooltip="ok";
            $arrayToDataTable[] = ['Année 2019', 'Reservations', ['role' => 'tooltip']];
            $arrayToDataTable[] = ['01', $tabMois['01'], $tabMois['01']];
            $arrayToDataTable[] = ['02', $tabMois['02'], $tabMois['02']];
            $arrayToDataTable[] = ['03', $tabMois['03'], $tabMois['03']];
            $arrayToDataTable[] = ['04', $tabMois['04'], $tabMois['04']];
            $arrayToDataTable[] = ['05', $tabMois['05'], $tabMois['05']];
            $arrayToDataTable[] = ['06', $tabMois['06'], $tabMois['06']];
            $arrayToDataTable[] = ['07', $tabMois['07'], $tabMois['07']];
            $arrayToDataTable[] = ['08', $tabMois['08'], $tabMois['08']];
            $arrayToDataTable[] = ['09', $tabMois['09'], $tabMois['09']];
            $arrayToDataTable[] = ['10', $tabMois['10'], $tabMois['10']];
            $arrayToDataTable[] = ['11', $tabMois['11'], $tabMois['11']];
            $arrayToDataTable[] = ['12', $tabMois['12'], $tabMois['12']];


            return $arrayToDataTable;
        }

        //Affichage du nombre d'utilisation de chaque voitures, pour une borne de temps donnée.
        public function calcul3($voitures, $debut, $fin)
        {
            $date1 = strtotime($debut);
            $date2 = strtotime($fin);

            $dates = array();

    
            for($i = $date1; $i <= $date2; $i += strtotime('+1 day', 0))
            {
                //On vire les samedis et dimanches
                if(!((date("w", $i) == 6) or (date("w",$i) == 0 )))
                {
                    $dates[] = date('Y-m-d', $i);
                }
            }

            $nombreDeJours = ($date2 - $date1)/86400;
            $datesEntete = $dates;
            array_unshift($datesEntete, ' ');

            $arrayToDataTable[] = $datesEntete;

            //$arrayToDataTable[] = $dates;

            foreach($voitures as $voiture)
            {
                $res = array();
                $res[] = $voiture->getNumero();
                foreach($dates as $date)
                {
                    $PR = $this->em->getRepository(Pointage::class);
                    //récupérations des pointages du jour pour le véhicule courant
                    $res[] = $PR->findByJour($voiture,$date);
                }
                $arrayToDataTable[] = $res;
            }

            

            return $arrayToDataTable;
        }

        //calcul des années bissextiles
        public function leap_year($year)
        {
            return date("L", mktime(0, 0, 0, 1, 1, $year));
        }
        
        public function nb_jours( $date1, $date2 )
        {
            $timestamp1    = strtotime($date1);
            $timestamp2    = strtotime($date2);
            
            $tot = 0; //total de jours entre les 2 dates
            //dates en jours de l'année ( depuis le 1er jan )
            $date1 = date("z", $timestamp1) ; // date de depart
            $date2 = date("z", $timestamp2) ; //date d'arrivée
            
            $day_stamp = 86400 ; //(3600 * 24 ); // un journée en timestamp
            //années des deux dates
            $year1 = date("Y", $timestamp1) ;
            $year2 = date("Y", $timestamp2) ;
            $num = 0; //nombre de jours feries a compter sur la duree totale
            $counter = 0; // la durée entre deux date par année
            
            $year = $year1; // l'année en cours ( defaut : $year1 )
            
            
            //on calcule le nombre de jours de difference entre les deux dates, en tenant
            // compte des années
            while ( $year <= $year2 )
            {
                $date3         = date("d-n-Y", mktime(0, 0, 0, 1,  1,  $year));
                $timestamp3 = strtotime($date3); 
            // date de référence pour l'année en cours
                $counter = 0; // compteur de jours pour chaque année
                
                //on récupère la date de pâques   
                $easterDate   = easter_date($year) ;
                $easterDay    = date('j', $easterDate) ;
                $easterMonth  = date('n', $easterDate) ;
                $easterYear   = date('Y', $easterDate) ;
            
                
                //le tableau sort les jours fériés de l'année depuis le premier janvier
                $closed = array
                (
                    // dates fixes
                    date("z", mktime(0, 0, 0, 1,  1,  $year)),  // 1er janvier
                    date("z", mktime(0, 0, 0, 5,  1,  $year)),  // Fête du travail
                    date("z", mktime(0, 0, 0, 5,  8,  $year)),  // Victoire des alliés
                    date("z", mktime(0, 0, 0, 7,  14, $year)),  // Fête nationale
                    date("z", mktime(0, 0, 0, 8,  15, $year)),  // Assomption
                    date("z", mktime(0, 0, 0, 11, 1,  $year)),  // Toussaint
                    date("z", mktime(0, 0, 0, 11, 11, $year)),  // Armistice
                    date("z", mktime(0, 0, 0, 12, 25, $year)),  // Noel
                    // Dates basées sur Paques
                    date("z", mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear)
                    ),  // Lundi de Paques
                    date("z", mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear
                    )), // Ascension
                    date("z", mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear
                    ))  // Lundi de Pentecote
                    
                );
                
                //si c'est la première année -> on commence par la date de depart; 
                //le compteur compte les jours jusqu'au 31dec
                if( $year == $year1 && $year < $year2 )
                { 
                    $i = $date1; 
                    $counter +=  (364+leap_year($year)) ; 
                }
                
            // si c'est ni la première ni la derniere année -> on commence au premier
            // janvier; 
                //le compteur compte tous les jours de l'année
                if( $year > $year1 && $year < $year2 )
                {
                    $i = date("z", mktime(0, 0, 0, 1,  1,  $year));  
                    $counter += 364+leap_year($year); 
                }
                // si c'est la dernière année -> on commence au premier janvier; 
                //le compteur va jusqu'a la date d'arrivée
                if( $year == $year2 && $year > $year1 )
                { 
                    $i = date("z", mktime(0, 0, 0, 1,  1,  $year)); 
                    $counter += $date2 ; 
                }
                
                // si les deux dates sont dans la même année
                if( $year == $year1 && $year == $year2 )
                { 
                    $i = $date1; 
                    $counter += $date2 ; 
                }
                
                //on boucle les jours sur la période donnée
                while ( $i <= $counter )
                {
                    $tot = $tot +1; // on ajoute 1 pour chaque jour passé en revue
                    if( in_array($i, $closed) ) 
                    {
                        $num++; // on ajoute 1 pour chaque jour férié rencontré
                    }
                    
                    //on compte chaque samedi et chaque dimanche
                    if(((date("w", $timestamp3 + $i * $day_stamp) == 6) or (date("w", 
            $timestamp3 + $i * $day_stamp) == 0)) and !in_array($i, $closed)) 
                    {
                        $num++ ;
                    }
                    $i++;
                }
                $year++ ; // on incremente l'année
            }
            $res = $tot - $num; 
            // nombre de jours entre les 2 dates fournies - nombre de jours non ouvrés
            return $res;
        }
}
