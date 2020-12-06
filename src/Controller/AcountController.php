<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UpdatePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AcountController extends AbstractController
{
    private $EntityManager;

    public function __construct(EntityManagerInterface $EntityManager)
    {
        $this->EntityManager = $EntityManager;
    }

    /**
     * @Route("/Compte", name="acount")
     */
    public function index()
    {
        $User = $this->getUser();
        $Form = $this->createForm(ChangePasswordType::class, $User, [
            'action' => $this->generateUrl('change_password'),
            'method' => 'POST'
        ]);

        return $this->render('acount/index.html.twig', [
            'Form' => $Form->createView()
        ]);

    }

    /**
     * @Route("/Modifier-le-mot-de-passe", name="change_password")
     */
    public function UpdatePassword(Request $Request,  UserPasswordEncoderInterface $Encoder)
    {

            $User = new User();
            $Form = $this->createForm(ChangePasswordType::class);
            $Form->handleRequest($Request);

            if($Form->isSubmitted() && $Form->isValid())
            {
                $Pass = $Form->get('password')->getData();

                if($Encoder->isPasswordValid($this->getUser(), $Pass) )
                {
                    $NewPass = $Form->get('new_password')->getData();
                    $NewPassH = $Encoder->encodePassword($this->getUser(), $NewPass);
                    $this->getUser()->setMpH('');
                    $this->getUser()->setPassword($NewPassH);
                    $this->EntityManager->flush();

                    $this->addFlash('notice', 'Votre mot de passe à bien été modifier.');
                    return $this->redirectToRoute('acount');
                }
                else
                {
                    $this->addFlash('Err', "Le mot de passe actuel n'est pas valide");
                    return $this->redirectToRoute('acount');
                }


            }
        else
        {
            return $this->redirectToRoute('home');
        }

    }





}
