<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Entity\Membre;
use App\Entity\User;
use App\Errors\Error;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
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
        $EmailConstraint->message = 'Adresse mail invalide.';
        $Errors = $Validator->validate($_POST['register']['email'], $EmailConstraint);

        $User = new User();
        $Form = $this->createForm(RegisterType::class, $User);

        $Doctrine = $this->getDoctrine()->getManager();
        $Form->handleRequest($Requette);

        $ErrorMsg = "";


        if ($Form->isSubmitted() && $Form->isValid() && 0 === count($Errors))
        {

            $BDD = $this->getDoctrine()->getRepository(User::class);
            $UserTest =  $BDD->findOneBy(['email' => $User->getEmail()] );

            if(!$UserTest)
            {

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
            else {
                $this->addFlash("Error", "Un compte existe déjà avec cette adresse mail");
                return $this->redirectToRoute('app_login');

            }
        }
        else
        {
            if(count($Errors) > 0)
            {
                $Msg = $Errors[0]->getMessage();
                $this->addFlash("Error", "" . $Msg);
            }
            else
                $this->addFlash("Error", "Les mots de passes doivent êtres identiques");


            return $this->redirectToRoute('app_login');

        }


    }

}


