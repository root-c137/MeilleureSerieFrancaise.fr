<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AcountController extends AbstractController
{
    /**
     * @Route("/Compte", name="acount")
     */
    public function index()
    {
        return $this->render('acount/index.html.twig');
    }
}
