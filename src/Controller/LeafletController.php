<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LeafletController extends AbstractController
{
    /**
     * @Route("/leaflet", name="leaflet")
     */
    public function index()
    {
        return $this->render('leaflet/index.html.twig', [
            'controller_name' => 'LeafletController',
        ]);
    }
}
