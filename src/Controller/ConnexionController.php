<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

class ConnexionController extends AbstractController
{
    /**
     * @Route("/connexion", name="Connexio")
     */
    public function index(Request $Requette)
    {

        return $this->render('connexion/index.html.twig', [
            'controller_name' => 'ConnexionController',
        ]);
    }
}


