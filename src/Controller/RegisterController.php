<?php

namespace App\Controller;

use App\Entity\Membre;
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
        $Membre = new Membre();
        $Form = $this->createForm(RegisterType::class, $Membre, [
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
        $Membre = new Membre();
        $Form = $this->createForm(RegisterType::class, $Membre);

        $Doctrine = $this->getDoctrine()->getManager();

        $Form->handleRequest($Requette);


        $E = 0;


        if($Form->isSubmitted() && $Form->isValid() )
        {
            $Membre = $Form->getData();
            $Membre->setIp($_SERVER['REMOTE_ADDR']);
            $Membre->setMpH($Form->get('Mp')->getData() );

            $Doctrine = $this->getDoctrine()->getManager();

            $Doctrine->persist($Membre);
            $Doctrine->flush();;
        }
        else
            $E = 1;

        return $this->redirectToRoute('home', [
            'Err' => $E
        ]);
    }
}


