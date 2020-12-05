<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AcountController extends AbstractController
{
    /**
     * @Route("/Compte", name="acount")
     */
    public function index()
    {
        $User = $this->getUser();
        $Form = $this->createForm(ChangePasswordType::class, $User);

        return $this->render('acount/index.html.twig', [
            'Form' => $Form->createView()
        ]);


    }


}
