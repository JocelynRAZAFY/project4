<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TableDynamicController extends AbstractController
{
    /**
     * @Route("/table/dynamic", name="table_dynamic")
     */
    public function index()
    {

        $tests = [
            ['day' => 1, 'article' => 'Bootstrap 4 CDN and Starter Template', 'author' => 'Cristina', 'shares' => '2.846'],
            ['day' => 2, 'article' => 'Bootstrap Grid 4 Tutorial and Examples', 'author' => 'Cristina', 'shares' => '3.417'],
            ['day' => 3, 'article' => 'Bootstrap Flexbox Tutorial and Examples', 'author' => 'Cristina', 'shares' => '1.234']
        ];
        return $this->render('table_dynamic/index.html.twig', [
            'controller_name' => 'TableDynamicController',
            'tests' => $tests,
        ]);
    }
}
