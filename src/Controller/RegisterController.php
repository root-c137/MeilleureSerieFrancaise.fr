<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\User;
use App\Errors\Error;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Route("/Inscription/{Err}", name="Inscription")
     */
    public function index2($Err)
    {
        $User = new User();
        $Form = $this->createForm(RegisterType::class, $User, [
            'action' => $this->generateUrl('NewMembre'),
            'method' => 'POST'
        ]);


        return $this->render('Inscription/Inscription.html.twig',[
            'Form' => $Form->createView(),
            'Err' => $Err
        ]);
    }

    /**
     * @Route("/NewMembre", name="NewMembre")
     */
    public function NewMembre(Request $Requette, UserPasswordEncoderInterface $Encoder, ValidatorInterface $Validator)
    {
        //Permet de tester si le mail est valide...


        $EmailConstraint = new Assert\Email();
        $EmailConstraint->message = 'Adresse mail invalid';
        $Errors = $Validator->validate($_POST['register']['email'], $EmailConstraint);


        $User = new User();
        $Form = $this->createForm(RegisterType::class, $User);

        $Doctrine = $this->getDoctrine()->getManager();
        $Form->handleRequest($Requette);

        $ErrorMsg = "";


        if ($Form->isSubmitted() && $Form->isValid() && 0 === count($Errors)) {
            $User = $Form->getData();
            $Pass = $Encoder->encodePassword($User, $User->getPassword());

            $User->setIp($_SERVER['REMOTE_ADDR']);
            $User->setMpH($User->getPassword());
            $User->setPassword($Pass);


            $Doctrine = $this->getDoctrine()->getManager();


            $Doctrine->persist($User);
            $Doctrine->flush();;
            return $this->redirectToRoute('home');
        }
        else
        {
            $ErrorMsg = $Errors[0]->getMessage();

            $E = new Error();
            $E->setMessage($ErrorMsg);

            //Stock temporairement le msg d'erreur dans la session Flash..
            $this->addFlash('Err', $ErrorMsg);

            return $this->redirectToRoute('app_login');

        }


    }

}


