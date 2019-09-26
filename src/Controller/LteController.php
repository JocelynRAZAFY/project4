<?php

namespace App\Controller;

use App\Services\ConnectService;
use App\Services\OauthGoogleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LteController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $token = null;

        return $this->render('lte/index.html.twig', [
            'controller_name' => 'LteController',
            'token' => $token
        ]);
    }

    /**
     * @Route("/connected", name="connected")
     */
    public function connected(OauthGoogleService $oauthGoogleService, Request $request)
    {
       $token = $oauthGoogleService->getTokenGoogle($request->query->all()['code']);

       if($token){
            return $this->redirectToRoute('index',['token' => $token]);
       }

        return $this->render('lte/index.html.twig', [
            'controller_name' => 'LteController',
            'token' => $token
        ]);
    }


}
