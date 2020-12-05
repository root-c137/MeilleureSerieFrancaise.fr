<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AcountPasswordController extends AbstractController
{
    /**
     * @Route("/Compte/Modifier-mot-de-passe", name="acount_password")
     */
    public function index()
    {
        $User = $this->getUser();
        $Form = $this->createForm(ChangePasswordType::class, $User);


        return $this->render('acount/ChangePassword.html.twig', [
            'Form' => $Form->createView()
        ]);
    }
}
