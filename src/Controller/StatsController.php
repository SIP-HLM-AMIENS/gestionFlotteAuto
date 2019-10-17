<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Pointage;
use App\Entity\Reservation;
use App\Service\StatsService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatsController extends AbstractController
{
    /**
     * @Route("/stats", name="stats")
     */
    public function index(StatsService $SS)
    {
        /*$repoVoiture = $this->getDoctrine()->getRepository(Voiture::class);
        $voitures = $repoVoiture->findAll();
        $arrayToDataTable = $SS->calcul1($voitures,'07');

        

        $test4 = new ColumnChart();
        $test4->getData()->SetArrayToDataTable($arrayToDataTable);
        $test4->getOptions()->setWidth(1200);
        $test4->getOptions()->setHeight(500);
        $test4->getOptions()->getVAxis()->setFormat('percent');
        $test4->getOptions()->getVAxis()->setTicks([0,0.25,0.50,0.75,1]);*/

        $repoReservation = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $repoReservation->findAll();

        /* ----------------------------------------------------------------------------------*/
        $col = new LineChart();
        $col->getData()->setArrayToDataTable($SS->Calcul2($reservations));
        $col->getOptions()->setTitle('Evolution des pointages sur l\'année');
        $col->getOptions()->setWidth(1200);
        $col->getOptions()->setHeight(500);


        return $this->render('stats/index.html.twig', [
            'controller_name' => 'StatsController',
            'test' => $col
        ]);
    }

    /**
     * @Route("/stats/majGraph/{mois}", name="majGraph")
     */
    public function majGraphMois(Request $request,StatsService $SS, $mois)
    {
        if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
        {
            $repoVoiture = $this->getDoctrine()->getRepository(Voiture::class);
            $voitures = $repoVoiture->findAll();
            $arrayToDataTable = $SS->calcul1($voitures,$mois);

            $graph = new ColumnChart();
            $graph->getData()->SetArrayToDataTable($arrayToDataTable);
            $graph->getOptions()->setWidth(1200);
            $graph->getOptions()->setHeight(500);
            $graph->getOptions()->getVAxis()->setFormat('percent');
            $graph->getOptions()->getVAxis()->setTicks([0,0.25,0.50,0.75,1]);

            return new Response(json_encode($arrayToDataTable));
        }
        return new Response("Nonnn ...."); 
    }

    /**
    * @Route("/stats/chargerTableau/{debut}_{fin}", name="chargeTableau")
    */
    public function chargeTableau(Request $request,StatsService $SS, $debut, $fin)
    {
        if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
        {
            $repoVoiture = $this->getDoctrine()->getRepository(Voiture::class);
            $voitures = $repoVoiture->findAll();
            $arrayToDataTable = $SS->calcul3($voitures,$debut,$fin);

            return new Response(json_encode($arrayToDataTable));
        }
        return new Response("Nonnn ...."); 
    }

    /**
     * @Route("/stats/Export/", name="export")
     */
    public function generateCsvAction(StatsService $SS, Request $request) {

        $debut = $request->request->get('_dateIn');
        $fin = $request->request->get('_dateOut');


        $spreadsheet = new Spreadsheet();

        $sheet =  $spreadsheet->getActiveSheet();

        $repoVoiture = $this->getDoctrine()->getRepository(Voiture::class);
        $voitures = $repoVoiture->findAll();
        $arrayData = $SS->calcul3($voitures,$debut,$fin);

        $sheet->fromArray($arrayData, NULL, 'A1');
        $sheet->setTitle("My First Worksheet");

        $writer = new Xlsx($spreadsheet);

        $filename = 'test.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);

        $writer->save($temp_file);

        return $this->file($temp_file, $filename, ResponseHeaderBag::DISPOSITION_INLINE);
    }  
    
}                         
