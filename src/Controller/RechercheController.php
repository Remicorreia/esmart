<?php

namespace App\Controller;

use App\Repository\SmartphoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    /**
     * @Route("/recherche-ajax", name="app_recherche_ajax")
     */
    

    public function ajax(Request $rq, SmartphoneRepository $spr): Response
    {
        $mot = $rq->query->get("search");
        $smartphonesTrouves = $spr->recherche($mot);
        return $this->render('recherche/ajax.html.twig', [
            'smartphones'  => $smartphonesTrouves,
            'mot'       => $mot
        ]);
    }
}
