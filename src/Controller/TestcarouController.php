<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestcarouController extends AbstractController
{
    #[Route('/testcarou', name: 'app_testcarou')]
    public function index(): Response
    {
        return $this->render('testcarou/index.html.twig', [
            'controller_name' => 'TestcarouController',
        ]);
    }
}
