<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\UpdatePasswordType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private $EntityManager;

    public function __construct(EntityManagerInterface $EntityManager)
    {
        $this->EntityManager = $EntityManager;
    }

    /**
     * @Route("/mot-de-passe-oublier", name="reset_password")
     */
    public function index(Request $Request)
    {
        if($this->getUser() )
        {
            return $this->redirectToRoute("home");
        }
        if($Request->get('email') )
        {
            $User = $this->EntityManager->getRepository(User::class)->findOneBy(['email' => $Request->get('email') ] );

            if($User)
            {
                $ResetPass = new ResetPassword();
                $ResetPass->setUser($User);
                $ResetPass->setCreatedAt(new \DateTime());
                $ResetPass->setToken(uniqid());

                $this->EntityManager->persist($ResetPass);
                $this->EntityManager->flush();

                $Content = "Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien ci-dessous :<br/><br/>";
                $url = "<a href='https://meilleureseriefrancaise.fr".$this->generateUrl('update_password', ['Token' => $ResetPass->getToken()])."'>Cliquez ici pour réinitialiser votre mot de passe</a>";
                $FooterContent = 'Ce message est envoyé automatiquement, merci de ne pas y répondre.';

                $Mail = new Mail();
                $Mail->send
                (
                    $User->getEmail(), 'Redéfinition de votre mot de passe..',
                    $Content.$url,
                    $FooterContent
                );

                $this->addFlash('Notice', 'Vous allez recevoir un mail afin de redéfinir votre mot de passe');
            }
            else
            {
                $this->addFlash('Err', "L'adresse mail ne correspond à aucun compte");
            }
        }




        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("/modifier-mot-de-passe/{Token}", name="update_password")
     */
    public function update(Request $Request, $Token, UserPasswordEncoderInterface $Encoder)
    {
        if($this->getUser())
        {
            return $this->redirectToRoute('home');

        }


        $ResetPass = $this->EntityManager->getRepository(ResetPassword::class)->findOneBy(['token' => $Token]);
        if($ResetPass)
        {
            $Form = $this->createForm(UpdatePasswordType::class);

            $Form->handleRequest($Request);
            if($Form->isSubmitted() && $Form->isValid())
            {
                $NewPass = $Form->get('password')->getData();
                $PassEncoder = $Encoder->encodePassword($ResetPass->getUser(), $NewPass);

                $ResetPass->getUser()->setPassword($PassEncoder);
                $ResetPass->getUser()->setMpH('');

                $this->EntityManager->remove($ResetPass);

                $this->EntityManager->flush();

                return $this->redirectToRoute('app_login');

            }
            return $this->render('reset_password/update.html.twig',[
                'Form' => $Form->createView()
            ]);
        }
        else
        {
            return $this->redirectToRoute('home');
        }
    }
}
