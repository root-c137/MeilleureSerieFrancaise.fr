<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/Inscription", name="Inscription")
     */
    public function index()
    {
        $User = new User();
        $Form = $this->createForm(RegisterType::class, $User, [
            'action' => $this->generateUrl('NewMembre'),
            'method' => 'POST'
        ]);


        return $this->render('Inscription/Inscription.html.twig',[
                'Form' => $Form->createView()
        ]);
    }

    /**
     * @Route("/NewMembre", name="NewMembre")
     */
    public function NewMembre(Request $Requette)
    {
        $User = new User();
        $Form = $this->createForm(RegisterType::class, $User);

        $Doctrine = $this->getDoctrine()->getManager();
        $Form->handleRequest($Requette);


        $E = 0;


        if($Form->isSubmitted() && $Form->isValid() )
        {
            $User = $Form->getData();
            $User->setIp($_SERVER['REMOTE_ADDR']);
            $User->setMpH($Form->get('password')->getData() );

            $Doctrine = $this->getDoctrine()->getManager();

            $Doctrine->persist($User);
            $Doctrine->flush();;
        }
        else
            $E = 1;

        return $this->redirectToRoute('home');
    }
}


