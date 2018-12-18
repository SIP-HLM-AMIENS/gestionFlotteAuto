<?php

namespace App\Command;

use App\Entity\Voiture;
use App\Entity\Pointage;
use App\Entity\Utilisateurs;
use App\Entity\PointageMobile;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class IntegrationPointageCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:integration-pointage';

    public function __construct(bool $requirePassword = false, ObjectManager $manager)
    {
        parent::__construct();
        $this->manager=$manager;

    }

    protected function configure()
    {
        $this
            ->setDescription('Intégration des pointages mobiles dans la tables des pointages')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->getContainer()->get('doctrine')->getEntityManager()->getRepository(PointageMobile::class);
        $emU = $this->getContainer()->get('doctrine')->getEntityManager()->getRepository(Utilisateurs::class);
        $emV = $this->getContainer()->get('doctrine')->getEntityManager()->getRepository(Voiture::class);

        $pointages = $em->findBy(['Synchro'=>false, 'depart'=>1]);

        foreach($pointages as $sortie)
        {
            $pointage = new Pointage();
            $entree = $em->findOneBy(['Synchro'=>false, 'depart'=>0, 'email'=>$sortie->getEmail(), 'immatriculation'=>$sortie->getImmatriculation()]);
            if(!is_null($entree))
            {
                $pointage->setSortie(new \DateTime($sortie->getHeureDepart()));
                $pointage->setEntree(new \DateTime($entree->getHeureArrivee()));
                $pointage->setKiloAvant($sortie->getKilometrage());
                $pointage->setKiloApres($entree->getKilometrage());
                $pointage->setEmplacement($entree->getPositionparking());
                $pointage->setObsApres($entree->getMotif());
                $pointage->setDestination($sortie->getDestination());


                $utilisateur = $emU->findOneBy(['email'=>$sortie->getEmail()]);
                $pointage->setUtilisateur($utilisateur);

                $voiture = $emV->findOneBy(['Numero'=>$sortie->getImmatriculation()]);
                $pointage->setVoiture($voiture);

                $voiture->setEmplacement($pointage->getEmplacement());
                $voiture->setKilometrage($pointage->getKiloApres());

                $sortie->setSynchro(true);
                $entree->setSynchro(true);

                $this->manager->persist($sortie);
                $this->manager->persist($entree);
                $this->manager->persist($pointage);
                $this->manager->persist($voiture);
                $this->manager->flush();

                $output->write($sortie->getIdPointage());
                $output->writeln(' -> '.$entree->getIdPointage());
            }
        }
        
        $io->success('Integration des pointages terminé avec succes !');
    }
}
