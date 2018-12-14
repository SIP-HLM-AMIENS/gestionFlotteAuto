<?php

namespace App\Command;

use App\Entity\PointageMobile;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class RecupPointageCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:recup-pointage';

    public function __construct(bool $requirePassword = false, ObjectManager $manager)
    {
        parent::__construct();
        $this->manager=$manager;

    }

    protected function configure()
    {
        $this
            ->setDescription('Récupération des pointages synchronisés par mobile')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->getContainer()->get('doctrine')->getEntityManager()->getRepository(PointageMobile::class);

        $output->writeln('Commande de récupération des pointage --- début !');
        
        //récupération des résultats du web service
        $jsonContent = file_get_contents("http://www.habitat-solution.fr/mobile/pointage.php");
        $resultat  = json_decode($jsonContent, true);
        foreach($resultat as $ligne)
        {   
            $output->write($ligne['id']);
            $output->write(' | ');
            $output->write($ligne['matriculation']);
            $output->write(' | ');
            $output->write($ligne['Depart']);
            $output->write(' | ');
            $output->write($ligne['kilometrage']);
            $output->write(' | ');
            $output->write($ligne['heuredepart']);
            $output->write(' | ');
            $output->write($ligne['heurearrivee']);
            $output->write(' | ');
            $output->write($ligne['Destination']);
            $output->write(' | ');
            $output->write($ligne['motif']);
            $output->write(' | ');
            $output->write($ligne['PositionParking']);
            $output->write(' | ');
            $output->write($ligne['Email']);


            $results = $em->findBy(['idPointage' => $ligne['id']]);
            if(count($results) == 0)
            {
                $PM = new PointageMobile();
                $PM->setIdPointage($ligne['id']);
                $PM->setImmatriculation($ligne['matriculation']);
                $PM->setDepart($ligne['Depart']);
                $PM->setKilometrage($ligne['kilometrage']);
                $PM->setHeureDepart($ligne['heuredepart']);
                $PM->setHeureArrivee($ligne['heurearrivee']);
                $PM->setDestination($ligne['Destination']);
                $PM->setMotif($ligne['motif']);
                $PM->setPositionParking($ligne['PositionParking']);
                $PM->setEmail($ligne['Email']);
                $PM->setSynchro(0);

                $this->manager->persist($PM);
                $this->manager->flush();

                $output->writeln(' ----> Ajouté');
            }
            else
            {
                $output->writeln(' ----> Déja Présent');
            }

        }
        $io->success("T'as vu ?");
    }
}
