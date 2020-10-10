<?php

namespace App\Controller;

use App\Entity\Serie;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $Rep = $this->getDoctrine()->getRepository(Serie::class);
        $Series =  $Rep->findAll();


        return $this->render('home/index.html.twig', [
            'Series' => $Series
        ]);
    }
}
