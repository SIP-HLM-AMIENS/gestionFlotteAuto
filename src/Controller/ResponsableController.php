<?php

namespace App\Controller;

use App\Entity\Ctass;
use App\Entity\Suivi;
use App\Entity\Voiture;
use App\Form\SuiviType;
use App\Entity\Controle;
use App\Entity\Assurance;
use App\Entity\Entretien;
use App\Form\ControleType;
use App\Form\EntretienType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResponsableController extends AbstractController
{
    /**
     * @Route("/gestionVoiture", name="gestionVoiture")
     */
    public function index()
    {
        $user = $this->getUser();
        $voitures = $user->getVoitures();


        return $this->render('responsable/index.html.twig', [
            'voitures' => $voitures
        ]);
    }

    /**
     * @Route("/gestionVoiture/{id}", name="informationVoiture")
     */
    public function information($id)
    {
        $user = $this->getUser();
        $voitures = $user->getVoitures();
        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $voiture = $repository->findOneBy(
            [
             'responsable'=> $user->getId(),
             'id' => $id
            ]
        );

        $repositoryControle = $this->getDoctrine()->getRepository(Controle::class);
        $controle = $repositoryControle->findOneBy(
            ['voiture' => $voiture],
            ['dateDebut' => 'DESC']
        );

        $repositoryAssurance = $this->getDoctrine()->getRepository(Assurance::class);
        $assurance = $repositoryAssurance->findOneBy(
            ['voiture' => $voiture],
            ['dateDebut' => 'DESC']
        );


        return $this->render('responsable/information.html.twig', [
            'voiture' => $voiture,
            'controle' => $controle,
            'assurance' => $assurance,
        ]);
    }

    /**
     * @Route("/gestionVoiture/{id}/ListeReservation", name="listeReservation")
     */
    public function ListeReservation($id)
    {
        $user = $this->getUser();
        $voitures = $user->getVoitures();
        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $voiture = $repository->findOneBy(
            [
             'responsable'=> $user->getId(),
             'id' => $id
            ]
        );

        return $this->render('responsable/listeReservation.html.twig', [
            'voiture' => $voiture
        ]);
        
    }

    /**
     * @Route("/gestionVoiture/{id}/toggle", name="toggle_voiture")
     */
    public function toggleVoiture(Request $request, $id)
    {
 
        if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
        {
                 
            $user = $this->getUser();
            $repository = $this->getDoctrine()->getRepository(Voiture::class);
            $voiture = $repository->findOneBy(
                [
                 'responsable'=> $user->getId(),
                 'id' => $id
                ]
            );
    
            $voiture->setEtat(!$voiture->getEtat());
            $this->getDoctrine()->getManager()->persist($voiture);
            $this->getDoctrine()->getManager()->flush();

            return new Response(($voiture->getEtat()) ? 'true' : 'false');
        }
        return new Response("Nonnn ....");    
    }

    /**
     * @Route("/Controle/create/{id}", name="controle_create")
     */
    public function controleCreate(Request $request, $id)
    {
        $controle = new Controle();

        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $voiture = $repository->findOneBy(
            [
             'responsable'=> $user->getId(),
             'id' => $id
            ]
        );
        $controle->setVoiture($voiture);
        
        $form = $this->createForm(ControleType::class, $controle, array(
            'action' => $this->generateUrl($request->get('_route'),array('id' => $id))
        ))
        ->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($controle);
            $this->getDoctrine()->getManager()->flush();
            return new Response('success');
        }
        
        return $this->render('responsable/_ControleCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Entretien/create/{id}", name="entretien_create")
     */
    public function entretienCreate(Request $request, $id)
    {
        $entretien = new Entretien();

        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $voiture = $repository->findOneBy(
            [
             'responsable'=> $user->getId(),
             'id' => $id
            ]
        );
        $entretien->setVoiture($voiture);
        
        $form = $this->createForm(EntretienType::class, $entretien, array(
            'action' => $this->generateUrl($request->get('_route'),array('id' => $id))
        ))
        ->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($entretien);
            $this->getDoctrine()->getManager()->flush();
            return new Response('success');
        }
        
        return $this->render('responsable/_EntretienCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Suivi/create/{id}", name="suivi_create")
     */
    public function suiviCreate(Request $request, $id)
    {
        $suivi = new Suivi();

        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(Voiture::class);
        $voiture = $repository->findOneBy(
            [
             'responsable'=> $user->getId(),
             'id' => $id
            ]
        );
        $suivi->setVoiture($voiture);
        
        $form = $this->createForm(SuiviType::class, $suivi, array(
            'action' => $this->generateUrl($request->get('_route'),array('id' => $id))
        ))
        ->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($suivi);
            $this->getDoctrine()->getManager()->flush();
            return new Response('success');
        }
        
        return $this->render('responsable/_SuiviCreate.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
